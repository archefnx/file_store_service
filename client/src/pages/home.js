import React, { useEffect, useState } from 'react';
import 'smart-webcomponents/source/modules/smart.grid.js';
import 'smart-webcomponents/source/styles/smart.default.css';
import { getFiles, downloadFile, deleteFile } from "../http/api"; // Импорт функции getTest и downloadFile
import FileModal from '../components/addFile'; // Импорт компонента FileModal

const Home = () => {
    const [data, setData] = useState([]);
    const [isModalOpen, setIsModalOpen] = useState(false);

    useEffect(() => {
      fetchData();
    }, []);

    const fetchData = async () => {
      try {
        const response = await getFiles();
        console.log(response.data); // Вывод данных в консоль
        setData(response.data);
      } catch (error) {
        console.error("Ошибка при получении данных: ", error);
      }
    };

    useEffect(() => {
      const dataSource = new window.Smart.DataAdapter({
        dataSource: data.map(file => ({
          ...file,
          size: (file.size / (1024 * 1024)).toFixed(2) + ' MB',
        })),
        dataFields: [
          'id: number',
          'name: string',
          'size: string',
          'extension: string'
        ]
      });
    
      const columns = [
        // { label: 'id', dataField: 'id', dataType: 'string' },
        { label: 'Название', dataField: 'name', dataType: 'string' },
        { label: 'Размер', dataField: 'size', dataType: 'string' },
        { label: 'Расширение', dataField: 'extension', dataType: 'string' },
        {
          label: 'Скачать', 
          dataField: 'download', 
          dataType: 'string', 
          width: 100,
          allowFilter: false, // Отключаем фильтрацию для этой колонки
          formatFunction: (settings) => {
            // Используем `settings.row.data.id` для получения ID текущей строки
            if (settings.row.data && settings.row.data.id !== undefined) {
              settings.template = `<button class="btn btn-primary" onclick="window.downloadFile(${settings.row.data.id})">Скачать</button>`;
            } else {
              settings.template = '';
            }
          },
        },
        {
          label: 'Действие', 
          dataField: 'action', 
          dataType: 'string',
          width: 250,
          allowFilter: false, // Отключаем фильтрацию для этой колонки
          formatFunction: (settings) => {
            const id = settings.row.data.id;
            settings.template = `
              <button class="btn btn-primary" onclick="window.editFile(${id})">Редактировать</button>
              <button class="btn btn-danger" onclick="window.deleteFile(${id})">Удалить</button>
            `;
          },
        }          
      ];
      
    
      const grid = document.querySelector('smart-grid');
      if (grid) {
        grid.columns = columns;
        grid.dataSource = dataSource;
        grid.filtering = { enabled: true, filterRow: { visible: false } };
      }

      // Глобальные функции
      window.downloadFile = async (id) => {
        try {
          const response = await downloadFile(id)
          const fileData = response.data; // Используйте функцию загрузки файла из API
          const filename = response.headers['original_name']
          console.log('response.headers[original_name]')
          console.log(response.headers['original_name'])

          console.log(fileData)
          // Создайте ссылку для загрузки файла
          const url = window.URL.createObjectURL(new Blob([fileData]));
          // Создайте ссылку для скачивания файла
          // console.log(fileData.data.original_name)
          const link = document.createElement('a');
          // const fileName = response.data.original_name;
          link.href = url;
          link.setAttribute('download', filename); // Установите имя файла
          // Добавьте ссылку на страницу и эмулируйте клик для скачивания файла
          document.body.appendChild(link);
          link.click();
          // Удалите ссылку после скачивания файла
          link.parentNode.removeChild(link);
        } catch (error) {
          console.error('Ошибка при скачивании файла: ', error);
        }
      };

      // Примерные функции для редактирования и удаления
      window.editFile = (id) => {
        alert(`Редактировать файл с ID: ${id}`);
      };

      window.deleteFile = async (id) => {
        try {
          const response = await deleteFile(id);
          console.log('Файл удален', response);
          
          // Обновляем данные после успешного удаления файла
          fetchData();
        } catch (error) {
          console.error("Ошибка при удалении файла: ", error);
        }
      };
      
    }, [data]);

    const handleModalOpen = () => {
      setIsModalOpen(true);
    };

    const handleModalClose = () => {
      setIsModalOpen(false);
    };

    const handleAddFile = (newFile) => {
      setData([...data, newFile]);
      setIsModalOpen(false);
    };

    return (
      <>
        <FileModal isOpen={isModalOpen} onClose={handleModalClose} onAddFile={handleAddFile} />
        <button onClick={handleModalOpen}>Добавить файл</button>
        <smart-grid style={{ width: '100%', height: '400px' }}></smart-grid>
      </>
    );
  };

export default Home;
