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

  nuevoDetalle = {
    fo_producto: 0,
    cantidad: 0,
    precio: 0
  };

  validar_fecha = true;
  validar_iva = true;
  validar_fo_proveedor = true;
  validar_fo_usuario = true;

  valdiar_fo_producto = true;
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
    if (this.validarCompra()) {

      this.scompras.insertarCompra(this.obj_compras).subscribe((datos: any) => {
        console.log("Datos recibidos de la API:", datos);
        console.log("Objeto compras");

        console.log(this.obj_compras);
        console.log("s compras");
        console.log(this.scompras);

        if (datos != null) {
          const idCompra = datos.id_compra; // Obtener el ID de la compra creada

          console.log("ID COMPRA ANTES DE GUARDARDETALLES");
          console.log(idCompra);

          this.guardarDetallesCompra(idCompra); // Guardar los detalles de la compra
        } else {
          alert("Error al guardar la compra: " + datos.mensaje); // Mensaje de error más específico
        }
      }
      );
    } else {
      alert("Por favor, complete todos los campos necesarios.");
    }
    console.log(this.obj_compras);
  }


  guardarDetallesCompra(idCompra: number) {
    console.log("COMPRAS ANTES DE GUARDAR DETALLES");
    console.log(this.obj_compras);


    const detallesConIdCompra = this.obj_compras.detalles.map((detalle) => ({
      ...detalle,
      fo_compras: Number(idCompra) // Asegúrate de que la clave foránea está incluida
    }));

    console.log("DETALLES CON ID COMPRA:");

    console.log(detallesConIdCompra);

    this.sdetalle.insertarDetalleCompra(detallesConIdCompra).subscribe(() => {
      this.limpiar();
      this.consulta(); // Actualiza la lista de compras
    });
  }


  // Validaciones para la compra
  validarCompra(): boolean {
    return (
      this.obj_compras.fecha.trim() !== '' &&
      this.obj_compras.iva > 0 &&
      this.obj_compras.fo_proveedor > 0 &&
      this.obj_compras.fo_usuario > 0 &&
      this.obj_compras.detalles.length > 0 // Asegúrate de que haya detalles
    );
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




}
