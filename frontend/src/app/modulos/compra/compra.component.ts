import { Component } from '@angular/core';
import { CompraService } from 'src/app/servicios/compra.service';
import { DetalleCompraService } from 'src/app/servicios/detalle-compra.service';
import { ProductoService } from 'src/app/servicios/producto.service';
import { ProveedorService } from 'src/app/servicios/proveedor.service';
import { UsuarioService } from 'src/app/servicios/usuario.service';

@Component({
  selector: 'app-compra',
  templateUrl: './compra.component.html',
  styleUrls: ['./compra.component.scss']
})
export class CompraComponent {
  compras: any[] = [];
  detalles: any[] = [];
  proveedores: any[] = [];
  usuarios: any[] = [];
  productos: any[] = [];

  obj_compras = {
    fecha: '',
    iva: 0,
    fo_proveedor: 0,
    fo_usuario: 0,
    detalles: [] as any[] // Arreglo para los detalles de compra
  };

  mform = false;

  constructor(private scompras: CompraService, private sdetalle: DetalleCompraService, private sproveedor: ProveedorService, private susuario: UsuarioService, private sproducto: ProductoService) { }


  ngOnInit(): void {
    this.consulta();
  }

  consulta() {
    this.scompras.consultarCompras().subscribe((compras: any) => {
      this.compras = compras;

      this.sdetalle.consultarDetallesCompra().subscribe((detalles: any) => {
        // this.detalles = detalles;

        this.mapearDetallesACompras(detalles);
      });
    });
  }

  mapearDetallesACompras(detalles: any) {
    console.log("En mapeo");
    console.log(detalles, this.compras);

    console.log("Compras antes de mapear:", this.compras);

    this.compras.forEach((compra: any) => {
      compra.detalles = detalles.filter((detalle: any) => {
        const foComprasNum = Number(detalle.fo_compras); 
        const idCompraNum = Number(compra.id_compra); 

        console.log("Comparando:", foComprasNum, idCompraNum);
        return foComprasNum === idCompraNum;
      });

    });
  }

  calcularTotalConIVA(compra: any): number {
    const subtotal = compra?.detalles?.reduce((total: number, detalle: any) => total + (detalle.cantidad * detalle.precio), 0) || 0;
    const iva = (subtotal * compra.iva) / 100;
    return subtotal + iva;
  }

  // Consultas adicionales para isnertar compra

  consultarProveedor() {
    this.sproveedor.consultarProveedores().subscribe((resultado: any) => {
      this.proveedores = resultado;
    });
  }

  consultarUsuario() {
    this.susuario.consultarUsuarios().subscribe((resultado: any) => {
      this.usuarios = resultado;
    });
  }

  consultarProductos() {
    this.sproducto.consultarProductos().subscribe((resultado: any) => {
      this.productos = resultado;
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


  


}
