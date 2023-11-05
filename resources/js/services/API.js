import axios from "axios";

export const administrador = () => {
    return new Promise((response, reject) => {
        axios.get('/api/admin').then(res => {
            response(res.data.config)
        }).catch(error => {
            console.log(error)
        })
    })
}

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

export const cursos_docente = () => {
    return new Promise((response, reject) => {
        axios.get('/api/v1/cursos-docentes').then(res => {
            response(res.data.cursos_docentes)
        }).catch(error => {
            console.log(error)
        })
    })
}

export const facilitador_check = (id) => {
    return new Promise((response, reject) => {
        axios.get('/api/v1/facilitadores-check', {
            params: {
                id: id
            }
        })
            .then(res => {
                response(res.data.facilitador)
            }).catch(error => {
                reject(error)
        })
    });
}


export const inscritos_get = (id_curso) => {
    return new Promise((response, reject) => {
        axios.get('/api/v1/inscritos', {
            params: {
                id: id_curso
            }
        }).then(res => {
            response(res.data.inscritos_docente)
        }).catch(error => {
            reject(error)
        })
    })
}
