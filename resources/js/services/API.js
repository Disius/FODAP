import axios from "axios";

export const detecciones = () => {
    return new Promise((response, reject) => {
        axios.get('/api/v1/detecciones').then(res => {
            response(res.data.detecciones)
        }).catch(error => {
            reject(error)
        })
    })
}
export const cursos = () => {
    return new Promise((response, reject) => {
        axios.get('/api/v1/cursos').then(res => {
            response(res.data.cursos)
        }).catch(error => {
            reject(error)
        })
    })
}
