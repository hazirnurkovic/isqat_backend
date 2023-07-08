import React from 'react';
import Modal from 'react-modal';
import '../../css/ChallengeModal.css';

const ChallengeModal = ({ isOpen, onClose, onSubmit, editingChallengeId, title, setTitle, value, setValue }) => {

  const handleFormSubmit = (e) => {
    e.preventDefault();
    if (onSubmit) {
      onSubmit(e);
    }
  };

  const modalTitle = editingChallengeId ? 'Edit Challenge' : 'Add New Challenge';
  const submitButtonLabel = editingChallengeId ? 'Update' : 'Submit';

  return (
    <Modal
      isOpen={isOpen}
      onRequestClose={onClose}
      className="challenge-modal"
      overlayClassName="challenge-modal-overlay"
      ariaHideApp={false}
    >
      <h2 className="challenge-modal-title">{modalTitle}</h2>
      <form onSubmit={handleFormSubmit}>
        <div className="challenge-modal-input">
          <label htmlFor="title">Title:</label>
          <input
            type="text"
            id="title"
            value={title}
            onChange={(e) => setTitle(e.target.value)}
          />
        </div>
        <div className="challenge-modal-input">
          <label htmlFor="value">Value:</label>
          <textarea
            id="value"
            value={value}
            onChange={(e) => setValue(e.target.value)}
          ></textarea>
        </div>
        <button type="submit" className="challenge-modal-button">
          {submitButtonLabel}
        </button>
      </form>
    </Modal>
  );
};

export default ChallengeModal;