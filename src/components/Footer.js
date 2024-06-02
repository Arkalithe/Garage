import React from 'react';
import { Col, Container, Row, Table } from 'react-bootstrap';

const daysOfWeek = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

const formatTime = (time) => {
  if (!time) return '';
  const [hours, minutes] = time.split(':');
  return `${hours}:${minutes}`;
};

const Footer = ({ horaire }) => {
  const groupedHours = daysOfWeek.map((day, index) => {
    const dayId = index + 1;
    const dayHours = horaire.filter(hour => hour.day_id === dayId);
    const morning = dayHours.find(hour => hour.time_period === 'Morning') || {};
    const afternoon = dayHours.find(hour => hour.time_period === 'Afternoon') || {};
    return {
      dayName: day,
      morning: morning.is_fermed ? 'Fermé' : `${formatTime(morning.heure_start)} - ${formatTime(morning.heure_fin)}`,
      afternoon: afternoon.is_fermed ? 'Fermé' : `${formatTime(afternoon.heure_start)} - ${formatTime(afternoon.heure_fin)}`
    };
  });

  return (
    <footer className="footer">
      <Container>
        <Row className="align-items-center pt-2">
          <Col xs={2} md={1}>
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" className="bi bi-clock" viewBox="0 0 16 16">
              <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z" />
              <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z" />
            </svg>
          </Col>

          <Col >
            {groupedHours.length > 0 ? (
              <Table bordered className='footer'>
                <thead>
                  <tr>
                    <th>Jour</th>
                    <th>Matin</th>
                    <th>Après-midi</th>
                  </tr>
                </thead>
                <tbody>
                  {groupedHours.map((day, index) => (
                    <tr key={index}>
                      <td><strong>{day.dayName}</strong></td>
                      <td>{day.morning}</td>
                      <td>{day.afternoon}</td>
                    </tr>
                  ))}
                </tbody>
              </Table>
            ) : (
              <div>Les horaires ne sont pas définis</div>
            )}
          </Col>
        </Row>
      </Container>
    </footer>
  );
};

export default Footer;
