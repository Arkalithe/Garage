import { useContext } from 'react';
import { HoraireContext } from '../context/HoraireContext';

const useHoraire = () => {
  return useContext(HoraireContext);
};

export default useHoraire;