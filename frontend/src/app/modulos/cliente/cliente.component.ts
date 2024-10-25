import { Component } from '@angular/core';
import { ClienteService } from 'src/app/servicios/cliente.service';

@Component({
  selector: 'app-cliente',
  templateUrl: './cliente.component.html',
  styleUrls: ['./cliente.component.scss']
})
export class ClienteComponent {
  cliente: any;

  constructor(private scliente: ClienteService) { }

  ngOnInit(): void { //se ejecuta cada vez que cargue el sitio
    this.consulta();
  }

  consulta() {
    this.scliente.consultarClientes().subscribe((resultado: any) => {
      this.cliente = resultado;
    })
  }
}
