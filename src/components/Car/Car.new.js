import React, { useRef, useState } from 'react'





export const CarNew = () => {
  const errRef = useRef();
  const nameRef = useRef();
  const messageRef = useRef();
  const noteRef = useRef();

  const [name, setName] = useState("");
  const [nameFocus, setNameFocus] = useState(false);

  const [message, setMessage] = useState("");
  const [validMessage, setValidMessage] = useState(false);
  const [messageFocus, setMessageFocus] = useState(false);

  const [note, setNote] = useState("");
  const [validNote, setValidNote] = useState(false);
  const [noteFocus, setNoteFocus] = useState(false);

  const [err, setErr] = useState('');
  const [success, setSuccess] = useState(false);


  const handleSubmit = () => {

  }

  return (
    <>



      <section className="form-cadre d-flex flex-column align-items-center">
        <p ref={errRef} className={err ? 'errmsg' : 'offscreen'} aria-live="assertive">
          {err}
        </p>

        <h1 className='d-flex flex-column p-2 m-2'> Votre Nom</h1>

        <form className='d-flex flex-column p-2 m-2' onSubmit={handleSubmit}>

          <label htmlFor="name">
            Name:
          </label>
          <input
            type="text"
            id="name"
            ref={nameRef}
            autoComplete="off"
            onChange={(e) => setName(e.target.value)}
            value={name}
            required
            onFocus={() => setNameFocus(true)}
            onBlur={() => setNameFocus(false)}
          />          
          <label htmlFor="message">
            Message :
          </label>
          <textarea 
            type="text-area"
            id="message"
            onChange={(e) => setMessage(e.target.value)}
            value={message}
            required
            onFocus={() => setMessageFocus(true)}
            onBlur={() => setMessageFocus(false)}>
          </textarea> 
          
          <label htmlFor="note">
            Note:
          </label>
          <input
            type="number"
            id="note"
            ref={noteRef}
            autoComplete="off"
            onChange={(e) => setNote(e.target.value)}
            value={note}
            required
            onFocus={() => setNoteFocus(true)}
            onBlur={() => setNoteFocus(false)}
          />
        </form>
      </section>

    </>
  )
}
