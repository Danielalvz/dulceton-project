import { Component } from '@angular/core';
import { UsuarioService } from 'src/app/servicios/usuario.service';

@Component({
  selector: 'app-usuario',
  templateUrl: './usuario.component.html',
  styleUrls: ['./usuario.component.scss']
})
export class UsuarioComponent {

  usuario: any;

  constructor(private susuario: UsuarioService) { }

  ngOnInit(): void { //se ejecuta cada vez que cargue el sitio
    this.consulta();
  }

  consulta() {
    this.susuario.consultarUsuarios().subscribe((resultado: any) => {
      this.usuario = resultado;
    })
  }

}
