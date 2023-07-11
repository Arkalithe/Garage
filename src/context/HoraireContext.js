import React, { useState, createContext } from 'react';

export const HoraireContext = createContext();

export const HoraireProvider = ({ children }) => {
  const [businessHours, setBusinessHours] = useState({
    mondayFriday: '9:00 H - 6:00 PM',
    saturday: '10:00 AM - 4:00 PM',
    sunday: 'Fermé'
  });

  const updateBusinessHours = (newBusinessHours) => {
    setBusinessHours(newBusinessHours);
  };

  return (
    <HoraireContext.Provider value={{ businessHours, updateBusinessHours }}>
      {children}
    </HoraireContext.Provider>
  );
};