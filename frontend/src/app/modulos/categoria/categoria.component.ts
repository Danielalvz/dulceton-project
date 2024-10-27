import { Component } from '@angular/core';
import { CategoriaService } from 'src/app/servicios/categoria.service';

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
}
