import { Component } from '@angular/core';
import { CiudadService } from 'src/app/servicios/ciudad.service';
import { ClienteService } from 'src/app/servicios/cliente.service';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-cliente',
  templateUrl: './cliente.component.html',
  styleUrls: ['./cliente.component.scss']
})
export class ClienteComponent {
  cliente: any;
  ciudad: any;

  obj_cliente = {
    identificacion: "",
    nombre: "",
    direccion: "",
    telefono: "",
    email: "",
    fo_ciudad: 0
  }

  validar_identificacion = true;
  validar_nombre = true;
  validar_direccion = true;
  validar_telefono = true;
  validar_email = true;
  validar_fo_ciudad = true;
  mform = false;

  constructor(private scliente: ClienteService, private sciudad: CiudadService) { }

  ngOnInit(): void { //se ejecuta cada vez que cargue el sitio
    this.consulta();
    this.consultarCiudad();
  }

  consulta() {
    this.scliente.consultarClientes().subscribe((resultado: any) => {
      this.cliente = resultado;
    })
  }

  consultarCiudad() {
    this.sciudad.consultarCiudades().subscribe((resultado: any) => {
      this.ciudad = resultado;
    });
  }

  mostrarForm(dato: any) {
    switch (dato) {
      case "ver":
        this.mform = true;
        break;
      case "ocultar":
        this.mform = false;
        break;
    }
  }

  limpiar() {
    this.obj_cliente = {
      identificacion: "",
      nombre: "",
      direccion: "",
      telefono: "",
      email: "",
      fo_ciudad: 0
    }
  }

  validarCliente() {

    this.validar_identificacion = this.obj_cliente.identificacion.trim() !== "";

    this.validar_nombre = this.obj_cliente.nombre.trim() !== "";

    this.validar_direccion = this.obj_cliente.direccion.trim() !== "";

    this.validar_telefono = this.obj_cliente.telefono.trim() !== "";

    this.validar_email = this.obj_cliente.email.trim() !== "";

    this.validar_fo_ciudad = this.obj_cliente.fo_ciudad !== 0;

    if (this.validar_identificacion && this.validar_nombre && this.validar_direccion && this.validar_telefono && this.validar_email && this.validar_fo_ciudad) {
      this.guardarCliente();

    }
  }

  guardarCliente() {
    this.scliente.insertarCliente(this.obj_cliente).subscribe((datos: any) => {
      console.log('Respuesta del servidor:', datos);
      if (datos.resultado === 'OK') {
        this.consulta();
      } else {
        console.error('Error en la respuesta del servidor:', datos.mensaje);
        alert('Error: ' + datos.mensaje);
      }

    });
    this.limpiar();
    this.mostrarForm("ocultar");
  }

  eliminar(id: number) {
    Swal.fire({
        title: "¿Está seguro de eliminar este cliente?",
        text: "El proceso no podrá ser revertido.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, Eliminar!",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            this.scliente.eliminarCliente(id).subscribe((datos: any) => {
                if (datos['resultado'] === 'OK') {
                    Swal.fire({
                        title: "Eliminado!",
                        text: "El cliente ha sido eliminado.",
                        icon: "success"
                    });
                    this.consulta(); 
                } else {
                    Swal.fire({
                        title: "Error",
                        text: datos.mensaje, 
                        icon: "error"
                    });
                }
            }, (error) => {
                Swal.fire({
                    title: "Error",
                    text: "No se pudo completar la solicitud. Intente nuevamente.",
                    icon: "error"
                });
            });
        }
    });
}

}
