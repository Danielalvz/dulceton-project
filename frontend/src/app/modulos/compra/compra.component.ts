import { Component } from '@angular/core';
import { CompraService } from 'src/app/servicios/compra.service';
import { DetalleCompraService } from 'src/app/servicios/detalle-compra.service';

@Component({
  selector: 'app-compra',
  templateUrl: './compra.component.html',
  styleUrls: ['./compra.component.scss']
})
export class CompraComponent {
  compras: any[] = [];
  detalles: any[] = [];

  constructor(private scompra: CompraService, private sdetalle: DetalleCompraService) { }

  ngOnInit(): void {
    this.consulta();
  }

  consulta() {
    // Primero obtenemos las compras
    this.scompra.consultarCompras().subscribe((compras: any) => {
      this.compras = compras;

      // Luego obtenemos los detalles de compra
      this.sdetalle.consultarDetallesCompra().subscribe((detalles: any) => {
        // this.detalles = detalles;

        // Ahora mapeamos los detalles a las compras correspondientes
        this.mapearDetallesACompras(detalles);
      });
    });
  }

  mapearDetallesACompras(detalles: any) {
    this.compras.forEach((compra: any) => {
      // Filtra los detalles que correspondan a cada compra usando la clave foránea
      compra.detalles = detalles.filter((detalle: any) => detalle.fo_compras === compra.id_compra);
    });
  }

  calcularTotalConIVA(compra: any): number {
    if (!compra.detalles || compra.detalles.length === 0) {
      return 0; // Si no hay detalles, el total es 0
    }

    const subtotal = compra.detalles.reduce((total: number, detalle: any) => total + (detalle.cantidad * detalle.precio), 0);
    const iva = (subtotal * compra.iva) / 100;
    return subtotal + iva;
  }
}
