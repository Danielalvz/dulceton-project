import { Component } from '@angular/core';
import { DetalleVentaService } from 'src/app/servicios/detalle-venta.service';
import { VentaService } from 'src/app/servicios/venta.service';

@Component({
  selector: 'app-pedido',
  templateUrl: './pedido.component.html',
  styleUrls: ['./pedido.component.scss']
})
export class PedidoComponent {
  ventas: any[] = [];
  detalles: any[] = [];

  constructor(private sventa: VentaService, private sdetalle: DetalleVentaService) { }

  ngOnInit(): void {
    this.consulta();
  }

  consulta() {
    // Primero obtenemos las compras
    this.sventa.consultarVentas().subscribe((ventas: any) => {
      this.ventas = ventas;

      // Luego obtenemos los detalles de compra
      this.sdetalle.consultarDetallesVenta().subscribe((detalles: any) => {
        // this.detalles = detalles;

        // Ahora mapeamos los detalles a las compras correspondientes
        this.mapearDetallesAVentas(detalles);
      });
    });
  }

  mapearDetallesAVentas(detalles: any) {
    this.ventas.forEach((venta: any) => {
      // Filtra los detalles que correspondan a cada compra usando la clave foránea
      venta.detalles = detalles.filter((detalle: any) => detalle.fo_venta === venta.id_venta);
    });
  }

  calcularTotalConIVA(venta: any): number {
    const subtotal = venta.detalles.reduce((total: number, detalle: any) => total + (detalle.cantidad * detalle.precio), 0);
    const iva = (subtotal * venta.iva) / 100;
    return subtotal + iva;
  }

}
