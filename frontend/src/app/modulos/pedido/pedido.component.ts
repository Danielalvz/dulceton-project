import { Component } from '@angular/core';
import { ClienteService } from 'src/app/servicios/cliente.service';
import { DetalleVentaService } from 'src/app/servicios/detalle-venta.service';
import { ProductoService } from 'src/app/servicios/producto.service';
import { UsuarioService } from 'src/app/servicios/usuario.service';
import { VentaService } from 'src/app/servicios/venta.service';

import Swal from 'sweetalert2';

@Component({
  selector: 'app-pedido',
  templateUrl: './pedido.component.html',
  styleUrls: ['./pedido.component.scss']
})
export class PedidoComponent {
  ventas: any[] = [];
  detalles: any[] = [];
  clientes: any[] = [];
  usuarios: any[] = [];
  productos: any[] = [];

  obj_ventas = {
    fecha: '',
    iva: 0,
    fo_cliente: 0,
    fo_usuario: 0,
    detalles: [] as any[]
  };

  nuevoDetalle = {
    fo_producto: 0,
    cantidad: 0,
    precio: 0
  };

  validar_fecha = true;
  validar_iva = true;
  validar_fo_cliente = true;
  validar_fo_usuario = true;

  validar_fo_producto = true;
  validar_cantidad = true;
  validar_precio = true;

  mform = false

  constructor(private sventa: VentaService, private sdetalle: DetalleVentaService, private scliente: ClienteService, private susuario: UsuarioService, private sproducto: ProductoService) { }

  ngOnInit(): void {
    this.consulta();
    this.consultarCliente();
    this.consultarUsuario();
    this.consultarProductos();
  }

  consulta() {
    this.sventa.consultarVentas().subscribe((ventas: any) => {
      this.ventas = ventas;

      this.sdetalle.consultarDetallesVenta().subscribe((detalles: any) => {
        this.mapearDetallesAVentas(detalles);
      });
    });
  }

  mapearDetallesAVentas(detalles: any) {
    this.ventas.forEach((venta: any) => {
      venta.detalles = detalles.filter((detalle: any) => detalle.fo_venta === venta.id_venta);
    });
  }

  calcularTotalConIVA(venta: any): number {
    const subtotal = venta?.detalles?.reduce((total: number, detalle: any) => total + (detalle.cantidad * detalle.precio), 0) || 0;
    const iva = (subtotal * venta.iva) / 100;
    return subtotal + iva;
  }

  consultarCliente() {
    this.scliente.consultarClientes().subscribe((resultado: any) => {
      this.clientes = resultado;
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

  agregarDetalle() {
    if (this.nuevoDetalle.fo_producto > 0 && this.nuevoDetalle.cantidad > 0 && this.nuevoDetalle.precio > 0) {
      this.obj_ventas.detalles.push({ ...this.nuevoDetalle });
      this.nuevoDetalle = { fo_producto: 0, cantidad: 0, precio: 0 };
    } else {
      alert("Debe ingresar todos los datos del detalle");
    }
  }

  guardarVenta() {

    this.sventa.insertarVenta(this.obj_ventas).subscribe(async (datos: any) => {
      console.log("Datos recibidos de la API:", datos);

      if (datos != null) {
        const idVenta = datos.id_venta;

        console.log(idVenta);

        await this.guardarDetallesVenta(idVenta);
      } else {
        alert("Error al guardar la venta: " + datos.mensaje);
      }
    }
    );
  }

  async guardarDetallesVenta(idVenta: number) {

    const detallesConIdVenta = this.obj_ventas.detalles.map((detalle) => ({
      ...detalle,
      fo_venta: Number(idVenta)
    }));


    for (let detalle of detallesConIdVenta) {
      await this.sdetalle.insertarDetalleVenta(detalle).toPromise()

    }

    this.limpiar();
    this.consulta();
  }

  validarVenta() {
    this.validar_iva = this.obj_ventas.iva > 0;

    this.validar_fecha = this.obj_ventas.fecha.trim() !== "";

    this.validar_fo_cliente = this.obj_ventas.fo_cliente !== 0;

    this.validar_fo_usuario = this.obj_ventas.fo_usuario > 0;

    this.validar_fo_producto = this.obj_ventas.detalles.length > 0 || this.nuevoDetalle.fo_producto > 0;

    this.validar_cantidad = this.obj_ventas.detalles.length > 0 || this.nuevoDetalle.cantidad > 0;

    this.validar_precio = this.obj_ventas.detalles.length > 0 || this.nuevoDetalle.precio > 0;


    if (this.validar_iva && this.validar_fecha && this.validar_fo_cliente && this.validar_fo_usuario && this.validar_fo_producto) {
      this.guardarVenta();
      alert("Venta guardada")
    }

  }

  limpiar() {
    this.obj_ventas = {
      fecha: '',
      iva: 0,
      fo_cliente: 0,
      fo_usuario: 0,
      detalles: []
    };
    this.nuevoDetalle = { fo_producto: 0, cantidad: 0, precio: 0 };
  }

  eliminar(idVenta: number) {
    Swal.fire({
      title: '¿Estás seguro?',
      text: '¡Esta acción eliminará la venta y todos sus detalles!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        this.sventa.eliminarVenta(idVenta).subscribe((respuesta: any) => {
          if (respuesta.resultado === "OK") {
            Swal.fire(
              'Eliminado!',
              respuesta.mensaje,
              'success'
            );
            this.consulta(); // Método para refrescar la lista de ventas
          } else {
            Swal.fire(
              'Error!',
              'No se pudo eliminar la venta.',
              'error'
            );
          }
        });
      }
    });

  }
}
