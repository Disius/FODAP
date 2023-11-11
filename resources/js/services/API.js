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
export const detecciones_desarrollo = () => {
    return new Promise((response, reject) => {
        axios.get('/api/v1/detecciones').then(res => {
            response(res.data.detecciones)
        }).catch(error => {
            reject(error)
        })
    })
}

export const cursos_desarrollo = () => {
    return new Promise((resolve, reject) => {
        axios.get('/api/v1/cursos-desarrollo').then(res => {
            resolve(res.data.cursos)
        }).catch(error => {
            reject(error)
        })
    })
}
export const detecciones_academicos = () => {
    return new Promise((response, reject) => {
        axios.get('/api/v1/detecciones-academicos').then(res => {
            response(res.data.detecciones)
        }).catch(error => {
            reject(error)
        })
    })
}
export const cursos_academicos = () => {
    return new Promise((resolve, reject) => {
        axios.get('/api/v1/cursos-academicos').then(res => {
            resolve(res.data.cursos)
        }).catch(error => {
            reject(error)
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
export const get_dates = () => {
    return new Promise((response, reject) => {
        axios.get('/api/v1/fechas-enable').then(res => {
            response(res.data.fechas)
        }).catch(error => {
            reject(error)
        })
    })
}
