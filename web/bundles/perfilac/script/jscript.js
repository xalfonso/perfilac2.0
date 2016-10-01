/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * Autor: Eduardo Alfonso Sanchez
 */
var $comboBoxProvincias;
var $comboBoxMunicipios;
var $comboBoxClientes;
var $comboBoxRepresentantes;
var $botonAdicionarProducto;
var $comboBoxProductos;
var $chexBoxhabilitarPass;
var $comboBoxTipoProducto;
var $comboBoxTipoEnchape;
var $indicadorProductoEncontrado;
var $indicadorProductoNoEncontrado;

$(document).ready(function() {
    /*Ajax*/
    $comboBoxProvincias = $('#id_provincias');
    $comboBoxMunicipios = $('#id_municipios');


    //si no existe el componente de municipios no tengo que asigarle el evento para llenarlo
    if ($comboBoxMunicipios.length)
        $comboBoxProvincias.change(obtenerMunicipios);


    $comboBoxClientes = $('#id_clientes');
    $comboBoxRepresentantes = $('#id_representantes');

    //si no existe el componente de representantes no tengo que asigarle el evento para llenarlo
    if ($comboBoxRepresentantes.length)
        $comboBoxClientes.change(obtenerRepresentantes);


    /*End Ajax*/

    /*Ajax de ver detalle del producto*/
    $comboBoxProductos = $('#id_productos');
    if ($comboBoxProductos.length)
        $comboBoxProductos.change(obtenerDetalleProducto);
    /*End Ajax de ver detalle del producto*/

    /*Ajax de listar productos*/
    $comboBoxTipoProducto = $('#id_tipoproductos');
    if ($comboBoxTipoProducto.length)
        $comboBoxTipoProducto.change(obtenerProductos);

    $comboBoxTipoEnchape = $('#id_tipoenchapes');
    if ($comboBoxTipoEnchape.length)
        $comboBoxTipoEnchape.change(obtenerProductos);

    /*End Ajax de listar productos*/



    //Fecha
    if ($('#inp_fecha').length)
        $('#inp_fecha').datepicker();
    //end Fecha


    /*Habilitar cambiar contraseña*/
    $chexBoxhabilitarPass = $('#id_habilitarModificarPass');
    if ($chexBoxhabilitarPass.length)
        $chexBoxhabilitarPass.click(abilitarActualPass);

    /*End Habilitar cambiar contraseña*/


    /*indicador de carga ajax productos*/
    $indicadorProductoEncontrado = $('#msg_producto_encontrado');
    $indicadorProductoEncontrado.hide();

    $indicadorProductoNoEncontrado = $('#msg_producto_noencontrado');
    $indicadorProductoNoEncontrado.hide();
    /*End indicador de carga ajax productos*/   


});

function abilitarActualPass()
{
    inputPass = document.getElementById("inp_pass");
    inputRPass = document.getElementById("inp_rpass");
    if (document.getElementById("id_habilitarModificarPass").checked)
    {
        inputPass.removeAttribute("disabled");
        inputRPass.removeAttribute("disabled");
    }
    else
    {
        inputPass.value = "";
        inputRPass.value = "";
        inputPass.setAttribute("disabled", "disabled");
        inputRPass.setAttribute("disabled", "disabled");
    }

}

function abrirFactura(direccion) {
    var subwindow = window.open(direccion);
}

function agregarProducto() {
    var fila = window.document.createElement("tr");

    //celda del codigo
    var celdaCodigo = window.document.createElement("td");
    var codigo = document.getElementById('inp_codigo');
    var codigoNode = window.document.createTextNode(codigo.value);

    //lo guardo en un campo oculto para poder tomarlo con una variable (guardo el id que es lo importante para obtenerlo de la BD)
    celdaCodigo.innerHTML = "<input type='hidden' value='" + document.getElementById('id_idproducto').value + "' name='idProductos[]' >";
    celdaCodigo.appendChild(codigoNode);

    //agregar a la fila la celda
    fila.appendChild(celdaCodigo);
    //End celda del codigo


    //celda de la ficha
    var celdaFicha = window.document.createElement("td");
    var ficha = document.getElementById('inp_nficha');
    var fichaNode = window.document.createTextNode(ficha.value);

    //lo guardo en un campo oculto para poder tomarlo con una variable
    //celdaFicha.innerHTML = "<input type='hidden' value='" + ficha.value + "' name='fichasProductos[]' >";
    celdaFicha.appendChild(fichaNode);

    //agregar a la fila la celda
    fila.appendChild(celdaFicha);
    //End celda de la ficha

    //celda de la descripcion
    var celdaDescripcion = window.document.createElement("td");
    var descripcion = document.getElementById('id_des');
    var descripcionNode = window.document.createTextNode(descripcion.value);

    //lo guardo en un campo oculto para poder tomarlo con una variable
    //celdaDescripcion.innerHTML = "<input type='hidden' value='" + descripcion.value + "' name='descripcionProductos[]' >";
    celdaDescripcion.appendChild(descripcionNode);

    //agregar a la fila la celda
    fila.appendChild(celdaDescripcion);
    //End celda de la descripcion

    //celda del ancho
    var celdaAncho = window.document.createElement("td");
    var ancho = document.getElementById('inp_ancho');
    var anchoNode = window.document.createTextNode(ancho.value);

    //lo guardo en un campo oculto para poder tomarlo con una variable
    celdaAncho.innerHTML = "<input type='hidden' value='" + ancho.value + "' name='anchosProductos[]' >";
    celdaAncho.appendChild(anchoNode);

    //agregar a la fila la celda
    fila.appendChild(celdaAncho);
    //End celda del ancho


    //celda del alto
    var celdaAlto = window.document.createElement("td");
    var alto = document.getElementById('inp_alto');
    var altoNode = window.document.createTextNode(alto.value);

    //lo guardo en un campo oculto para poder tomarlo con una variable
    celdaAlto.innerHTML = "<input type='hidden' value='" + alto.value + "' name='altosProductos[]' >";
    celdaAlto.appendChild(altoNode);

    //agregar a la fila la celda
    fila.appendChild(celdaAlto);
    //End celda del alto

    //celda del cantidad
    var celdaCant = window.document.createElement("td");
    var cant = document.getElementById('inp_cant');
    var cantNode = window.document.createTextNode(cant.value);

    //lo guardo en un campo oculto para poder tomarlo con una variable
    celdaCant.innerHTML = "<input type='hidden' value='" + cant.value + "' name='cantProductos[]' >";
    celdaCant.appendChild(cantNode);

    //agregar a la fila la celda
    fila.appendChild(celdaCant);
    //End celda de la cantidad


    //celda de los m2
    var celdaM2 = window.document.createElement("td");
    var m2 = (ancho.value / 1000) * (alto.value / 1000) * cant.value;
    var m2Node = window.document.createTextNode(m2.toPrecision(3));

    //lo guardo en un campo oculto para poder tomarlo con una variable
    //celdaM2.innerHTML = "<input type='hidden' value='" + m2 + "' name='m2Productos[]' >";
    celdaM2.appendChild(m2Node);

    //agregar a la fila la celda
    fila.appendChild(celdaM2);
    //End celda de los m2


    //celda del precio CUC
    var celdaPrecioCUC = window.document.createElement("td");
    var precioCUC = document.getElementById('inp_cuc');
    var preCUC = precioCUC.value /** m2 / cant.value*/;
    var precioCUCNode = window.document.createTextNode(preCUC);

    //lo guardo en un campo oculto para poder tomarlo con una variable
    //celdaPrecioCUC.innerHTML = "<input type='hidden' value='" + precioCUC.value + "' name='preciosCUCProductos[]' >";
    celdaPrecioCUC.appendChild(precioCUCNode);

    //agregar a la fila la celda
    fila.appendChild(celdaPrecioCUC);
    //End celda del precio CUC

    //celda del importe CUC
    var celdaImporteCUC = window.document.createElement("td");
    var importeCUC = preCUC * cant.value;
    var importeCUCNode = window.document.createTextNode(importeCUC);

    //lo guardo en un campo oculto para poder tomarlo con una variable
    //celdaImporteCUC.innerHTML = "<input type='hidden' value='" + importeCUC + "' name='importesCUCProductos[]' >";
    celdaImporteCUC.appendChild(importeCUCNode);

    //agregar a la fila la celda
    fila.appendChild(celdaImporteCUC);
    //End celda del importe CUC

    //celda del precio CUP
    var celdaPrecioCUP = window.document.createElement("td");
    var precioCUP = document.getElementById('inp_cup');
    var preCUP = precioCUP.value /** m2 / cant.value*/;
    var precioCUPNode = window.document.createTextNode(preCUP);

    //lo guardo en un campo oculto para poder tomarlo con una variable
    //celdaPrecioCUP.innerHTML = "<input type='hidden' value='" + precioCUP.value + "' name='preciosCUPProductos[]' >";
    celdaPrecioCUP.appendChild(precioCUPNode);

    //agregar a la fila la celda
    fila.appendChild(celdaPrecioCUP);
    //End celda del precio CUP


    //celda del importe CUP
    var celdaImporteCUP = window.document.createElement("td");
    var importeCUP = preCUP * cant.value;
    var importeCUPNode = window.document.createTextNode(importeCUP);

    //lo guardo en un campo oculto para poder tomarlo con una variable
    //celdaImporteCUP.innerHTML = "<input type='hidden' value='" + importeCUP + "' name='importesCUPProductos[]' >";
    celdaImporteCUP.appendChild(importeCUPNode);

    //agregar a la fila la celda
    fila.appendChild(celdaImporteCUP);
    //End celda del importe CUP

    var celdaEliminar = window.document.createElement("td");
    celdaEliminar.innerHTML = "<a style='cursor: pointer' onclick='eliminarElementoProductoVenta(this)'>Eliminar</a>";

    //agregar a la fila la celda  
    fila.appendChild(celdaEliminar);


    //poner visible la fila insertada
    var tabla = window.document.getElementById("listado_producto");
    var filaCabecera = window.document.getElementById('fila_Cabecera_producto');
    filaCabecera.className = "";

    //agrego la fila a la tabla
    tabla.appendChild(fila);


}

function eliminarElementoProductoVenta(elementoEliminar) {
    var elementoEvento = elementoEliminar;
    var elemePadreCelda = elementoEvento.parentNode;
    var elemePadreFila = elemePadreCelda.parentNode;
    var elemPadreTabla = elemePadreFila.parentNode;
    elemPadreTabla.removeChild(elemePadreFila);


    tabla = window.document.getElementById('listado_producto');

    var $filas = $('#listado_producto tr');

    if ($filas.length == 1) {
        var filaCabecera = window.document.getElementById('fila_Cabecera_producto');
        filaCabecera.className = "ganar_oculto";
    }

}


function obtenerMunicipios() {

    $.ajax({
        // la URL para la petición
        url: '../listarMunicipioProvinciaAjax/' + document.getElementById("id_provincias").value,
        // la información a enviar
        data: {},
        // especifica si será una petición POST o GET
        type: 'GET',
        // el tipo de información que se espera de respuesta
        dataType: 'text',
        // código a ejecutar si la petición es satisfactoria;
        // la respuesta es pasada como argumento a la función
        success: function(datos) {
            $comboBoxMunicipios.html(datos);

        },
        // código a ejecutar si la petición falla;
        // son pasados como argumentos a la función
        // el objeto jqXHR (extensión de XMLHttpRequest), un texto con el estatus
        // de la petición y un texto con la descripción del error que haya dado el servidor
        error: function(jqXHR, status, error) {
            //aqui voy a limpiar los comboBox dependientes
            $comboBoxMunicipios.html("");
        },
        // código a ejecutar sin importar si la petición falló o no
        complete: function(jqXHR, status) {

        }
    });
}


function obtenerRepresentantes() {

    $.ajax({
        // la URL para la petición
        url: '../listarRepresentanteClienteAjax/' + document.getElementById("id_clientes").value,
        // la información a enviar
        data: {},
        // especifica si será una petición POST o GET
        type: 'GET',
        // el tipo de información que se espera de respuesta
        dataType: 'text',
        // código a ejecutar si la petición es satisfactoria;
        // la respuesta es pasada como argumento a la función
        success: function(datos) {
            $comboBoxRepresentantes.html(datos);

        },
        // código a ejecutar si la petición falla;
        // son pasados como argumentos a la función
        // el objeto jqXHR (extensión de XMLHttpRequest), un texto con el estatus
        // de la petición y un texto con la descripción del error que haya dado el servidor
        error: function(jqXHR, status, error) {
            //aqui voy a limpiar los comboBox dependientes
            $comboBoxRepresentantes.html("");
        },
        // código a ejecutar sin importar si la petición falló o no
        complete: function(jqXHR, status) {

        }
    });
}

function obtenerDetalleProducto() {

    $.ajax({
        // la URL para la petición
        url: '../listarDetalleProductoAjax/' + document.getElementById("id_productos").value,
        // la información a enviar
        data: {},
        // especifica si será una petición POST o GET
        type: 'GET',
        // el tipo de información que se espera de respuesta
        dataType: 'text',
        // código a ejecutar si la petición es satisfactoria;
        // la respuesta es pasada como argumento a la función
        success: function(datos) {
            var datosPartes = datos.split("<>");

            var inpId = document.getElementById("id_idproducto");
            inpId.value = datosPartes[0];

            var inpCodigo = document.getElementById("inp_codigo");
            inpCodigo.value = datosPartes[1];

            var inpNoFicha = document.getElementById("inp_nficha");
            inpNoFicha.value = datosPartes[2];

            var inpPrecioCUP = document.getElementById("inp_cup");
            inpPrecioCUP.value = datosPartes[3];

            var inpPrecioCUC = document.getElementById("inp_cuc");
            inpPrecioCUC.value = datosPartes[4];

            var inpColor = document.getElementById("inp_color");
            inpColor.value = datosPartes[5];

            var inpDescripcon = document.getElementById("id_des");
            inpDescripcon.value = datosPartes[6];

        },
        // código a ejecutar si la petición falla;
        // son pasados como argumentos a la función
        // el objeto jqXHR (extensión de XMLHttpRequest), un texto con el estatus
        // de la petición y un texto con la descripción del error que haya dado el servidor
        error: function(jqXHR, status, error) {
            //aqui voy los input
            limpiarDetalleProducto()
        },
        // código a ejecutar sin importar si la petición falló o no
        complete: function(jqXHR, status) {

        }
    });
}

function obtenerProductos() {

    $.ajax({
        // la URL para la petición
        url: '../listarProductosAjax/' + document.getElementById("id_tipoproductos").value + '/' + document.getElementById("id_tipoenchapes").value,
        // la información a enviar
        data: {},
        // especifica si será una petición POST o GET
        type: 'GET',
        // el tipo de información que se espera de respuesta
        dataType: 'json',
        // código a ejecutar si la petición es satisfactoria;
        // la respuesta es pasada como argumento a la función
        success: function(json) {
            $comboBoxProductos.html("");

            //alert(json.length);
            for (var i = 0; i < json.length; i++) {
                var item = json[i];
                $('<option value="' + item.id + '">' + item.codigo + '</option>').appendTo($comboBoxProductos);
            }

            /*Si se obtiene algun producto mando a mostrar los detalles del primero de la lista*/
            /*En caso que no existan productos limpio los detalles de algun viejo que pueda quedar*/
            if (json.length > 0) {
                obtenerDetalleProducto();
                $indicadorProductoEncontrado.show(200).delay(2000).hide(600);

            }
            else {
                limpiarDetalleProducto();
                $indicadorProductoNoEncontrado.show(200).delay(2000).hide(600);
            }



        },
        // código a ejecutar si la petición falla;
        // son pasados como argumentos a la función
        // el objeto jqXHR (extensión de XMLHttpRequest), un texto con el estatus
        // de la petición y un texto con la descripción del error que haya dado el servidor
        error: function(jqXHR, status, error) {
            $comboBoxProductos.html("");
            alert('Ha ocurrido un error al cargar los productos!!!. Intente de Nuevo');
        },
        // código a ejecutar sin importar si la petición falló o no
        complete: function(jqXHR, status) {

        }
    });
}

function limpiarDetalleProducto() {
    var inpCodigo = document.getElementById("inp_codigo");
    inpCodigo.value = "";

    var inpNoFicha = document.getElementById("inp_nficha");
    inpNoFicha.value = "";

    var inpPrecioCUP = document.getElementById("inp_cup");
    inpPrecioCUP.value = "";

    var inpPrecioCUC = document.getElementById("inp_cuc");
    inpPrecioCUC.value = "";

    var inpColor = document.getElementById("inp_color");
    inpColor.value = "";

    var inpDescripcon = document.getElementById("id_des");
    inpDescripcon.value = "";
}

function validar() {
    if (existenProductosVenta() == false) {
        window.alert("Imposible realizar la operación. No se han incluidos productos");
        return false;
    }
    return true;
}



function existenProductosVenta() {
    var $filas = $('#listado_producto tr');

    if ($filas.length > 1)
        return true;
    return  false;

}