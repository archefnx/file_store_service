import React, { useState } from 'react';
import { Button } from 'smart-webcomponents-react/button';
import { uploadFile } from '../http/api'; // Импортируем функцию загрузки файла

const FileModal = ({ isOpen, onClose, onAddFile }) => {
  const [newFileName, setNewFileName] = useState('');
  const [selectedFile, setSelectedFile] = useState(null);

  const handleFileChange = (e) => {
    setSelectedFile(e.target.files[0]);
    console.log(e.target.files[0])
  };

  const handleAddFile = async () => {
    try {
      const formData = new FormData();
      formData.append('file', selectedFile);
      formData.append('name', newFileName || '');

      console.log('selectedFile')
      console.log(selectedFile)
      console.log('formData.file')
      console.log(formData.get('name'));
      
      const response = await uploadFile(formData); // Используем функцию загрузки файла

      onClose(); 
      if (onAddFile) {
        onAddFile(response.file);
      }
    } catch (error) {
      console.error("Ошибка при добавлении файла: ", error);
    }
  };

  return (
    <>
      {isOpen && (
        <div className="modal" style={{ display: 'block', position: 'fixed', zIndex: 1, left: 0, top: 0, width: '100%', height: '100%', overflow: 'auto', backgroundColor: 'rgba(0,0,0,0.4)' }}>
          <div className="modal-content" style={{ backgroundColor: '#fefefe', margin: '15% auto', padding: '20px', border: '1px solid #888', width: '80%', borderRadius: '8px' }}>
            <span className="close" style={{ color: '#aaa', float: 'right', fontSize: '28px', fontWeight: 'bold' }} onClick={onClose}>&times;</span>
            <div>
              <label htmlFor="fileName">Наименование файла:</label>
              <input type="text" id="fileName" value={newFileName} onChange={(e) => setNewFileName(e.target.value)} style={{ marginBottom: '10px', width: '100%', padding: '8px', boxSizing: 'border-box', borderRadius: '4px', border: '1px solid #ccc' }} />
            </div>
            <div>
              <label htmlFor="fileInput">Выберите файл:</label>
              <input type="file" id="fileInput" onChange={handleFileChange} style={{ marginBottom: '10px', width: '100%', padding: '8px', boxSizing: 'border-box', borderRadius: '4px', border: '1px solid #ccc' }} />
            </div>
            <Button onClick={handleAddFile} style={{ backgroundColor: 'green', color: 'white', border: 'none', padding: '10px 20px', borderRadius: '4px', cursor: 'pointer' }}>Добавить файл</Button>
          </div>
        </div>
      )}
    </>
  );
};

export default FileModal;
