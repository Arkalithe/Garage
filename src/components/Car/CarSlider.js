import React from 'react';
import { Slider } from "@mui/material";

const CarSlider = ({ label, value, onChange, min, max, resetFunc }) => (
  <div className="card voit mx-auto mb-3" style={{ maxWidth: "600px" }}>
    <div className="card-body">
      <div>
        <label>{label}:</label>
        <span className="mx-1">
          {value[0]} - {value[1]}
        </span>
      </div>
      <div className="d-flex align-items-center">
        <Slider
          getAriaLabel={() => `${label} Range`}
          value={value}
          onChange={onChange}
          valueLabelDisplay="auto"
          min={min}
          max={max}
          sx={{ width: "300px", mx: "10px" }}
        />
        <button type="button" className="ms-3 bouton" onClick={resetFunc}>
          Reset
        </button>
      </div>
    </div>
  </div>
);

export default CarSlider;
