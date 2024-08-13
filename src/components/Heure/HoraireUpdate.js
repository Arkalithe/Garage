import React, { useEffect, useState } from 'react';
import { Form, Container, Row, Col } from 'react-bootstrap';
import config from '../../api/axios';

const daysOfWeek = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
const timeOptions = Array.from({ length: 24 }, (_, i) => {
  const hour = String(i).padStart(2, '0');
  return [`${hour}:00`, `${hour}:30`];
}).flat();

const HoraireUpdate = () => {
  const update_url = '/api/horaires';
  const fetch_url = '/api/horaires';

  const [businessHours, setBusinessHours] = useState([]);
  const [groupedHours, setGroupedHours] = useState([]);

  useEffect(() => {
    fetchBusinessHours();
  }, []);

  const fetchBusinessHours = async () => {
    try {
      const response = await config.localTestingUrl.get(fetch_url);
      const fetchedHours = response.data;
      setBusinessHours(fetchedHours);
      groupBusinessHours(fetchedHours);
    } catch (error) {
      console.error('Erreur recuperation horaires', error);
    }
  };

  const groupBusinessHours = (hours) => {
    const grouped = daysOfWeek.map((day, index) => {
      const dayId = index + 1;
      const dayHours = hours.filter(hour => hour.day_id === dayId);
      const morning = dayHours.find(hour => hour.time_period === 'Morning') || {};
      const afternoon = dayHours.find(hour => hour.time_period === 'Afternoon') || {};
      return {
        dayId,
        dayName: day,
        morning,
        afternoon
      };
    });
    setGroupedHours(grouped);
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      for (const group of groupedHours) {
        const { morning, afternoon } = group;
        const hoursToUpdate = [morning, afternoon].filter(hour => hour.id);
        for (const hour of hoursToUpdate) {
          const { id, day_id, heure_start, heure_fin, time_period, is_fermed } = hour;
          const data = { id, day_id, heure_start, heure_fin, time_period, is_fermed };
          await config.localTestingUrl.patch(update_url, JSON.stringify(data));
        }
      }
    } catch (error) {
      console.error('Erreur mise à jour horaires', error);
    }
  };

  const handleInputChange = (e, dayId, period, key) => {
    const updatedGroupedHours = groupedHours.map(group => {
      if (group.dayId === dayId) {
        const updatedPeriod = { ...group[period], [key]: key === 'is_fermed' ? e.target.checked : e.target.value };
        return { ...group, [period]: updatedPeriod };
      }
      return group;
    });
    setGroupedHours(updatedGroupedHours);
  };

  return (
    <Container className="p-3 my-3 form-cadre">
      <h3>Modifiez Horaire</h3>
      <Form onSubmit={handleSubmit}>
        <Row className="mb-3">
          <Col xs={2}></Col>
          <Col xs={4}><h5>Matin</h5></Col>
          <Col xs={4}><h5>Après-midi</h5></Col>
          <Col xs={2}></Col>
        </Row>
        {groupedHours.map(({ dayId, dayName, morning, afternoon }) => (
          <Row className="align-items-center mb-3" key={dayId}>
            <Col xs={12} md={2}>
              <Form.Group as={Row} className="align-items-center">
                <Col>
                  <Form.Control plaintext readOnly value={dayName} />
                </Col>
              </Form.Group>
            </Col>
            <Col xs={6} md={4}>
              <Form.Group as={Row} className="align-items-center mb-2">
                <Form.Label column sm={4}>Ouverture:</Form.Label>
                <Col sm={8}>
                  <Form.Control
                    as="select"
                    value={morning.heure_start || ''}
                    onChange={(e) => handleInputChange(e, dayId, 'morning', 'heure_start')}
                  >
                    <option value="">Sélectionnez</option>
                    {timeOptions.map((time, idx) => (
                      <option key={idx} value={time}>{time}</option>
                    ))}
                  </Form.Control>
                </Col>
              </Form.Group>
              <Form.Group as={Row} className="align-items-center">
                <Form.Label column sm={4}>Fermeture:</Form.Label>
                <Col sm={8}>
                  <Form.Control
                    as="select"
                    value={morning.heure_fin || ''}
                    onChange={(e) => handleInputChange(e, dayId, 'morning', 'heure_fin')}
                  >
                    <option value="">Sélectionnez</option>
                    {timeOptions.map((time, idx) => (
                      <option key={idx} value={time}>{time}</option>
                    ))}
                  </Form.Control>
                </Col>
              </Form.Group>
            </Col>
            <Col xs={6} md={4}>
              <Form.Group as={Row} className="align-items-center mb-2">
                <Form.Label column sm={4}>Ouverture:</Form.Label>
                <Col sm={8}>
                  <Form.Control
                    as="select"
                    value={afternoon.heure_start || ''}
                    onChange={(e) => handleInputChange(e, dayId, 'afternoon', 'heure_start')}
                  >
                    <option value="">Sélectionnez</option>
                    {timeOptions.map((time, idx) => (
                      <option key={idx} value={time}>{time}</option>
                    ))}
                  </Form.Control>
                </Col>
              </Form.Group>
              <Form.Group as={Row} className="align-items-center">
                <Form.Label column sm={4}>Fermeture:</Form.Label>
                <Col sm={8}>
                  <Form.Control
                    as="select"
                    value={afternoon.heure_fin || ''}
                    onChange={(e) => handleInputChange(e, dayId, 'afternoon', 'heure_fin')}
                  >
                    <option value="">Sélectionnez</option>
                    {timeOptions.map((time, idx) => (
                      <option key={idx} value={time}>{time}</option>
                    ))}
                  </Form.Control>
                </Col>
              </Form.Group>
            </Col>
            <Col xs={12} md={2}>
              <Form.Group as={Row} className="align-items-center">
                <Form.Label column sm={4}>Fermé:</Form.Label>
                <Col sm={8}>
                  <Form.Check
                    type="checkbox"
                    checked={morning.is_fermed || afternoon.is_fermed || false}
                    onChange={(e) => handleInputChange(e, dayId, morning.id ? 'morning' : 'afternoon', 'is_fermed')}
                  />
                </Col>
              </Form.Group>
            </Col>
          </Row>
        ))}
        <button className="bouton" type="submit">Envoyez</button>
      </Form>
    </Container>
  );
};

export default HoraireUpdate;
