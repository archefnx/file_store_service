import { $host } from ".";

export const getFiles = async () => {
    const response = await $host.get('api/file')
    return response
} 

export const downloadFile = async (id) => {
    const response = await $host.get('api/download/' + id)
    return response
} 
