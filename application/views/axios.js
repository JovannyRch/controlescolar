// Curso


function getCurso(){
    var url = "";
    axios.get(url)
    .then(response => {
        this.Curso = response.data;
    }).catch(error => {
        this.Curso = [];
    });
}

function postCurso( nombre, descripcion){
    var url = "";
    var data = {
		nombre : nombre,
		descripcion : descripcion
    };
    axios.post(url,data)
    .then(response => {
        console.log("Éxito en post de Curso");
    }).catch(error => {
        console.log("Error en post de Curso");
    });
}

function putCurso(id_curso, nombre, descripcion){
    var url = ""+id_curso;
    var data = {
		nombre : nombre,
		descripcion : descripcion
    };
    axios.put(url,data)
    .then(response => {
        console.log("Éxito en put de Curso");
    }).catch(error => {
        console.log("Error en put de Curso");
    });
}

function deleteCurso(id_curso){
    var url = ""+id_curso;
    axios.delete(url)
    .then(response => {
        console.log("Éxito en delete de Curso");
    }).catch(error => {
        console.log("Éxito en delete de Curso");
    });
}

 // Asignatura

 
function getAsignatura(){
    var url = "";
    axios.get(url)
    .then(response => {
        this.Asignatura = response.data;
    }).catch(error => {
        this.Asignatura = [];
    });
}

function postAsignatura( id_profesor, id_curso, nombre, descripcion){
    var url = "";
    var data = {
		id_profesor : id_profesor,
		id_curso : id_curso,
		nombre : nombre,
		descripcion : descripcion
    };
    axios.post(url,data)
    .then(response => {
        console.log("Éxito en post de Asignatura");
    }).catch(error => {
        console.log("Error en post de Asignatura");
    });
}

function putAsignatura(id_asignatura, id_profesor, id_curso, nombre, descripcion){
    var url = ""+id_asignatura;
    var data = {
		id_profesor : id_profesor,
		id_curso : id_curso,
		nombre : nombre,
		descripcion : descripcion
    };
    axios.put(url,data)
    .then(response => {
        console.log("Éxito en put de Asignatura");
    }).catch(error => {
        console.log("Error en put de Asignatura");
    });
}

function deleteAsignatura(id_asignatura){
    var url = ""+id_asignatura;
    axios.delete(url)
    .then(response => {
        console.log("Éxito en delete de Asignatura");
    }).catch(error => {
        console.log("Éxito en delete de Asignatura");
    });
}

 // Asignaturas_usuario

 
function getAsignaturas_usuario(){
    var url = "";
    axios.get(url)
    .then(response => {
        this.Asignaturas_usuario = response.data;
    }).catch(error => {
        this.Asignaturas_usuario = [];
    });
}

function postAsignaturas_usuario( id_usuario, id_asignatura){
    var url = "";
    var data = {
		id_usuario : id_usuario,
		id_asignatura : id_asignatura
    };
    axios.post(url,data)
    .then(response => {
        console.log("Éxito en post de Asignaturas_usuario");
    }).catch(error => {
        console.log("Error en post de Asignaturas_usuario");
    });
}

function putAsignaturas_usuario(id_asignaturas_usuario, id_usuario, id_asignatura){
    var url = ""+id_asignaturas_usuario;
    var data = {
		id_usuario : id_usuario,
		id_asignatura : id_asignatura
    };
    axios.put(url,data)
    .then(response => {
        console.log("Éxito en put de Asignaturas_usuario");
    }).catch(error => {
        console.log("Error en put de Asignaturas_usuario");
    });
}

function deleteAsignaturas_usuario(id_asignaturas_usuario){
    var url = ""+id_asignaturas_usuario;
    axios.delete(url)
    .then(response => {
        console.log("Éxito en delete de Asignaturas_usuario");
    }).catch(error => {
        console.log("Éxito en delete de Asignaturas_usuario");
    });
}

//Calificaciones


function getCalificaciones(){
    var url = "";
    axios.get(url)
    .then(response => {
        this.Calificaciones = response.data;
    }).catch(error => {
        this.Calificaciones = [];
    });
}

function postCalificaciones( calificacion){
    var url = "";
    var data = {
		calificacion : calificacion
    };
    axios.post(url,data)
    .then(response => {
        console.log("Éxito en post de Calificaciones");
    }).catch(error => {
        console.log("Error en post de Calificaciones");
    });
}

function putCalificaciones(id_calificacion, calificacion){
    var url = ""+id_calificacion;
    var data = {
		calificacion : calificacion
    };
    axios.put(url,data)
    .then(response => {
        console.log("Éxito en put de Calificaciones");
    }).catch(error => {
        console.log("Error en put de Calificaciones");
    });
}

function deleteCalificaciones(id_calificacion){
    var url = ""+id_calificacion;
    axios.delete(url)
    .then(response => {
        console.log("Éxito en delete de Calificaciones");
    }).catch(error => {
        console.log("Éxito en delete de Calificaciones");
    });
}

// Convocatorias



function getConvocatorias(){
    var url = "";
    axios.get(url)
    .then(response => {
        this.Convocatorias = response.data;
    }).catch(error => {
        this.Convocatorias = [];
    });
}

function postConvocatorias( convocatoria){
    var url = "";
    var data = {
		convocatoria : convocatoria
    };
    axios.post(url,data)
    .then(response => {
        console.log("Éxito en post de Convocatorias");
    }).catch(error => {
        console.log("Error en post de Convocatorias");
    });
}

function putConvocatorias(id_convocatoria, convocatoria){
    var url = ""+id_convocatoria;
    var data = {
		convocatoria : convocatoria
    };
    axios.put(url,data)
    .then(response => {
        console.log("Éxito en put de Convocatorias");
    }).catch(error => {
        console.log("Error en put de Convocatorias");
    });
}

function deleteConvocatorias(id_convocatoria){
    var url = ""+id_convocatoria;
    axios.delete(url)
    .then(response => {
        console.log("Éxito en delete de Convocatorias");
    }).catch(error => {
        console.log("Éxito en delete de Convocatorias");
    });
}

 
 // Aulas

 

function getAula(){
    var url = "";
    axios.get(url)
    .then(response => {
        this.Aula = response.data;
    }).catch(error => {
        this.Aula = [];
    });
}

function postAula( nombre, descripcion){
    var url = "";
    var data = {
		nombre : nombre,
		descripcion : descripcion
    };
    axios.post(url,data)
    .then(response => {
        console.log("Éxito en post de Aula");
    }).catch(error => {
        console.log("Error en post de Aula");
    });
}

function putAula(id_aula, nombre, descripcion){
    var url = ""+id_aula;
    var data = {
		nombre : nombre,
		descripcion : descripcion
    };
    axios.put(url,data)
    .then(response => {
        console.log("Éxito en put de Aula");
    }).catch(error => {
        console.log("Error en put de Aula");
    });
}

function deleteAula(id_aula){
    var url = ""+id_aula;
    axios.delete(url)
    .then(response => {
        console.log("Éxito en delete de Aula");
    }).catch(error => {
        console.log("Éxito en delete de Aula");
    });
}

 
 