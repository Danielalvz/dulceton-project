import { Component } from '@angular/core';
import { CategoriaService } from 'src/app/servicios/categoria.service';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-categoria',
  templateUrl: './categoria.component.html',
  styleUrls: ['./categoria.component.scss']
})
export class CategoriaComponent {

  categoria: any;

  obj_categoria = {
    nombre: ""
  }

  validar_nombre = true;
  mform = false;

  constructor(private scategoria: CategoriaService) { }

  ngOnInit(): void { //se ejecuta cada vez que cargue el sitio
    this.consulta();
  }

  consulta() {
    this.scategoria.consultarCategorias().subscribe((resultado: any) => {
      this.categoria = resultado;
    })
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
    this.obj_categoria = {
      nombre: ""
    }
  }

  validarCategoria() {
    this.validar_nombre = this.obj_categoria.nombre.trim() !== "";

    if (this.validar_nombre) {
      this.guardarCategoria();
    }
  }

  guardarCategoria() {
    this.scategoria.insertarCategoria(this.obj_categoria).subscribe((datos: any) => {
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
      title: "¿Está seguro de eliminar esta categoría?",
      text: "El proceso no podrá ser revertido.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, Eliminar!",
      cancelButtonText: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        // Llamar al servicio para eliminar la categoría
        this.scategoria.eliminarCategoria(id).subscribe((datos: any) => {
          if (datos['resultado'] === 'OK') {
            Swal.fire({
              title: "Eliminado!",
              text: "Tu categoría ha sido eliminada.",
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
