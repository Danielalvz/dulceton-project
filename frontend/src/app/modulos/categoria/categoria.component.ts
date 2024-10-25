import { Component } from '@angular/core';
import { CategoriaService } from 'src/app/servicios/categoria.service';

@Component({
  selector: 'app-categoria',
  templateUrl: './categoria.component.html',
  styleUrls: ['./categoria.component.scss']
})
export class CategoriaComponent {

  categoria: any;

  constructor(private scategoria: CategoriaService) { }

  ngOnInit(): void { //se ejecuta cada vez que cargue el sitio
    this.consulta();
  }

  consulta() {
    this.scategoria.consultarCategorias().subscribe((resultado: any) => {
      this.categoria = resultado;
    })
  }
}
