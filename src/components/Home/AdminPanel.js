import React from 'react';

const AdminPanel = ({ title, imageSrc, description, handleTitleChange, handleImageChange, handleDescriptionChange }) => {
  return (
    <div className="admin-controls">
      <h4>Admin Controls</h4>
      <label htmlFor="title">Title:</label>
      <input type="text" id="title" value={title} onChange={handleTitleChange} />

      <label htmlFor="image">Image Source:</label>
      <input type="text" id="image" value={imageSrc} onChange={handleImageChange} />

      <label htmlFor="description">Description:</label>
      <textarea id="description" value={description} onChange={handleDescriptionChange} />
    </div>
  );
};

export default AdminPanel;