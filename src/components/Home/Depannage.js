import React, { useState } from 'react';
import AdminPanel from './AdminPanel';

const Depannage = () => {
  const [title, setTitle] = useState('Dépannage');
  const [imageSrc, setImageSrc] = useState('../assets/Image/Voiture.png');
  const [description, setDescription] = useState(
    'Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum'
  );

  const handleTitleChange = (event) => {
    setTitle(event.target.value);
  };

  const handleImageChange = (event) => {
    setImageSrc(event.target.value);
  };

  const handleDescriptionChange = (event) => {
    setDescription(event.target.value);
  };

  return (
    <article className="col-md-4 form-cadre m-2 p-2">
      <div className="pb-2">
        <h1>{title}</h1>
      </div>
      <div className="pb-3">
        <img className="img-fluid" src={imageSrc} alt={title} />
      </div>
      <div>
        <p>{description}</p>
      </div>
      <button className="bouton bouton-lien">Plus d'information</button>

      <AdminPanel
        title={title}
        imageSrc={imageSrc}
        description={description}
        handleTitleChange={handleTitleChange}
        handleImageChange={handleImageChange}
        handleDescriptionChange={handleDescriptionChange}
      />
    </article>
  );
};

export default Depannage;