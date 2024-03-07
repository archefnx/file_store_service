import { $host } from "./index";
import { $hostBlob } from "./httpBlob"; 

export const getFiles = async () => {
    const response = await $host.get('api/file')
    return response
} 

export const downloadFile = async (id) => {
    try {
      // Выполните запрос к серверу для загрузки файла по его id
      const response = await $hostBlob.get(`api/download/${id}`);
      console.log('response.headers[original_name]')
      console.log(response.headers['original_name'])


      return response; // Верните полученный файл
    } catch (error) {
      throw error; // Обработайте ошибку, если она возникнет
    }
  };

export const deleteFile = async (id) => {
    const response = await $host.get('api/delete/' + id)
    return response
} 

export const createFile = async (id) => {
    const response = await $host.get('api/delete/' + id)
    return response
} 

export const uploadFile = async (fileData) => {
    console.log(1)
    console.log(fileData.get('file'))
    // const formData = new FormData();
    // formData.append('file', fileData.file);
    // formData.append('name', fileData.name || '');

    const response = await $host.post('api/upload', fileData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    });

    return response.data;
}
