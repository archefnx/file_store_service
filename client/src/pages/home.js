import React, { useEffect, useState } from 'react';
import 'smart-webcomponents/source/modules/smart.grid.js';
import 'smart-webcomponents/source/styles/smart.default.css';
import { getFiles, downloadFile as apiDownloadFile } from "../http/api"; // Импорт функции getTest и downloadFile

const Home = () => {
    const [data, setData] = useState([]);

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
        { label: 'id', dataField: 'id', dataType: 'string' },
        { label: 'Название', dataField: 'name', dataType: 'string' },
        { label: 'Размер', dataField: 'size', dataType: 'string' },
        { label: 'Расширение', dataField: 'extension', dataType: 'string' },
        {
          label: 'Скачать', 
          dataField: 'download', 
          dataType: 'string', 
          width: 100,
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
          width: 200,
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
        grid.filtering = { enabled: true, filterRow: { visible: true } };
      }

      // Глобальные функции
      window.downloadFile = async (id) => {
        try {
          const response = await apiDownloadFile(id);
          // Обработка ответа, например, скачивание файла
          console.log('Файл скачан', response);
        } catch (error) {
          console.error("Ошибка при скачивании файла: ", error);
        }
      };

      // Примерные функции для редактирования и удаления
      window.editFile = (id) => {
        alert(`Редактировать файл с ID: ${id}`);
      };

      window.deleteFile = (id) => {
        alert(`Удалить файл с ID: ${id}`);
      };
    }, [data]);
    

    return (
      <>
        <smart-grid style={{ width: '100%', height: '400px' }}></smart-grid>
      </>
    );
  };

export default Home;
