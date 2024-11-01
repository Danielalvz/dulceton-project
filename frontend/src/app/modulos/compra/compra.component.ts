import { Component } from '@angular/core';
import { CompraService } from 'src/app/servicios/compra.service';
import { DetalleCompraService } from 'src/app/servicios/detalle-compra.service';
import { ProductoService } from 'src/app/servicios/producto.service';
import { ProveedorService } from 'src/app/servicios/proveedor.service';
import { UsuarioService } from 'src/app/servicios/usuario.service';

import Swal from 'sweetalert2';

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

  nuevoDetalle = {
    fo_producto: 0,
    cantidad: 0,
    precio: 0
  };

  validar_fecha = true;
  validar_iva = true;
  validar_fo_proveedor = true;
  validar_fo_usuario = true;

  validar_fo_producto = true;
  validar_cantidad = true;
  validar_precio = true;

  mform = false;

  constructor(private scompras: CompraService, private sdetalle: DetalleCompraService, private sproveedor: ProveedorService, private susuario: UsuarioService, private sproducto: ProductoService) { }


  ngOnInit(): void {
    this.consulta();
    this.consultarProveedor();
    this.consultarUsuario();
    this.consultarProductos();
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

  agregarDetalle() {
    if (this.nuevoDetalle.fo_producto > 0 && this.nuevoDetalle.cantidad > 0 && this.nuevoDetalle.precio > 0) {
      this.obj_compras.detalles.push({ ...this.nuevoDetalle });
      this.nuevoDetalle = { fo_producto: 0, cantidad: 0, precio: 0 };
    } else {
      alert("Debe ingresar todos los datos del detalle");
    }
  }

  guardarCompra() {

    this.scompras.insertarCompra(this.obj_compras).subscribe(async (datos: any) => {
      console.log("Datos recibidos de la API:", datos);
      console.log("Objeto compras");

      console.log(this.obj_compras);
      console.log("s compras");
      console.log(this.scompras);

      if (datos != null) {
        const idCompra = datos.id_compra;

        console.log("ID COMPRA ANTES DE GUARDARDETALLES");
        console.log(idCompra);

        await this.guardarDetallesCompra(idCompra);
      } else {
        alert("Error al guardar la compra: " + datos.mensaje);
      }
      console.log(this.obj_compras);
    }
    );
  }




  async guardarDetallesCompra(idCompra: number) {
    console.log("COMPRAS ANTES DE GUARDAR DETALLES");
    console.log(this.obj_compras);


    const detallesConIdCompra = this.obj_compras.detalles.map((detalle) => ({
      ...detalle,
      fo_compras: Number(idCompra)
    }));

    console.log("DETALLES CON ID COMPRA:");

    console.log(detallesConIdCompra);

    for (let detalle of detallesConIdCompra) {
      await this.sdetalle.insertarDetalleCompra(detalle).toPromise()

    }
    // this.sdetalle.insertarDetalleCompra(detallesConIdCompra).subscribe(() => {
    this.limpiar();
    this.consulta(); // Actualiza la lista de compras
    // });
  }


  // // Validaciones para la compra
  validarCompra() {
    this.validar_iva = this.obj_compras.iva > 0;
    console.log("Iva:", this.validar_iva);


    this.validar_fecha = this.obj_compras.fecha.trim() !== "";
    console.log("Fecha:", this.validar_fecha);


    this.validar_fo_proveedor = this.obj_compras.fo_proveedor !== 0;
    console.log("FO_PROVEEDOR", this.validar_fo_proveedor);


    this.validar_fo_usuario = this.obj_compras.fo_usuario > 0;
    console.log("FO_USUARIO:", this.validar_fo_usuario);


    // Verificar si hay al menos un detalle con producto, cantidad y precio
    this.validar_fo_producto = this.obj_compras.detalles.length > 0 && this.obj_compras.detalles.some(detalle =>
      detalle.fo_producto > 0 && detalle.cantidad > 0 && detalle.precio > 0
    );
    console.log("FO_PRODUCTO:", this.validar_fo_producto);

    // Validar detalles también
    this.validar_cantidad = this.obj_compras.detalles.some(detalle => detalle.cantidad > 0);
    this.validar_precio = this.obj_compras.detalles.some(detalle => detalle.precio > 0);

    if (this.validar_iva && this.validar_fecha && this.validar_fo_proveedor && this.validar_fo_usuario && this.validar_fo_producto) {
      this.guardarCompra();
      alert("Compra guardada");
    } else {
      alert("Por favor, complete todos los campos requeridos y asegúrese de agregar al menos un detalle válido.");
    }
  }

  limpiar() {
    this.obj_compras = {
      fecha: '',
      iva: 0,
      fo_proveedor: 0,
      fo_usuario: 0,
      detalles: []
    };
    this.nuevoDetalle = { fo_producto: 0, cantidad: 0, precio: 0 };
  }

  eliminar(idCompra: number) {
    Swal.fire({
      title: '¿Estás seguro?',
      text: '¡Esta acción eliminará la compra y todos sus detalles!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Sí, eliminar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        this.scompras.eliminarCompra(idCompra).subscribe((respuesta: any) => {
          if (respuesta.resultado === "OK") {
            Swal.fire(
              'Eliminado!',
              respuesta.mensaje,
              'success'
            );
            this.consulta();
          } else {
            Swal.fire(
              'Error!',
              'No se pudo eliminar la compra.',
              'error'
            );
          }
        });
      }
    });
  }
}


