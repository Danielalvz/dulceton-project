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
  proveedor: any[] = [];
  usuario: any[] = [];
  productos: any[] = [];

  obj_compras = {
    fecha: '',
    iva: 0,
    fo_proveedor: 0,
    fo_usuario: 0
  }

  nuevos_detalles = [
    {
      fo_compras: 0,
      fo_producto: 0,
      cantidad: 0,
      precio: 0
    }
  ];

  nuevoProducto = {
    nombre: '',
    precio: 0
  };

  validar_fecha = true;
  validar_iva = true;
  validar_fo_proveedor = true;
  validar_fo_usuario = true;
  validacionesDetalles = [{ fo_compras: true, fo_producto: true, cantidad: true, precio: true }];
  mform = false;

  constructor(private scompra: CompraService, private sdetalle: DetalleCompraService, private sproveedor: ProveedorService, private susuario: UsuarioService, private sproducto: ProductoService) { }

  ngOnInit(): void {
    this.consulta();
    this.consultarProveedor();
    this.consultarUsuario();
    this.consultarProductos();

    this.validacionesDetalles = this.nuevos_detalles.map(() => ({
      fo_compras: true,
      fo_producto: true,
      cantidad: true,
      precio: true
  }));
  }

  consulta() {
    // Primero obtenemos las compras
    this.scompra.consultarCompras().subscribe((compras: any) => {
      this.compras = compras || [];

      // Luego obtenemos los detalles de compra
      this.sdetalle.consultarDetallesCompra().subscribe((detalles: any) => {
        // this.detalles = detalles;

        // Ahora mapeamos los detalles a las compras correspondientes
        this.mapearDetallesACompras(detalles);
      });
    });
  }

  consultarProveedor() {
    this.sproveedor.consultarProveedores().subscribe((resultado: any) => {
      this.proveedor = resultado;
    });
  }

  consultarUsuario() {
    this.susuario.consultarUsuarios().subscribe((resultado: any) => {
      this.usuario = resultado;
    });
  }

  consultarProductos() {
    this.sproducto.consultarProductos().subscribe((resultado: any) => {
      this.productos = resultado;
    });
  }

  mapearDetallesACompras(detalles: any) {
    this.compras.forEach((compra: any) => {
      // Filtra los detalles que correspondan a cada compra usando la clave foránea
      compra.detalles = detalles.filter((detalle: any) => detalle.fo_compras === compra.id_compra) || [];
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
    this.obj_compras = {
      fecha: '',
      iva: 0,
      fo_proveedor: 0,
      fo_usuario: 0
    }

    this.nuevos_detalles = [
      { fo_compras: 0, fo_producto: 0, cantidad: 0, precio: 0 }
    ];
  }

  validarCompra() {
    this.validar_fecha = this.obj_compras.fecha.trim() !== "";

    this.validar_iva = this.obj_compras.iva > 0;

    this.validar_fo_proveedor = this.obj_compras.fo_proveedor > 0;

    this.validar_fo_usuario = this.obj_compras.fo_usuario > 0;


    // Validación de cada detalle de compra
  let detallesValidos = true;
  this.validacionesDetalles = this.nuevos_detalles.map((detalle) => {
    const esValido = {
      fo_compras: true, // Agrega la propiedad fo_compras aquí, ajusta según tu lógica
      fo_producto: detalle.fo_producto > 0,
      cantidad: detalle.cantidad > 0,
      precio: detalle.precio > 0
    };

    // Actualizamos la variable para la validación global
    if (!esValido.fo_producto || !esValido.cantidad || !esValido.precio) {
      detallesValidos = false;
    }

    return esValido;
  });

  if (this.validar_fecha && this.validar_iva && this.validar_fo_proveedor && this.validar_fo_usuario && detallesValidos) {
    this.guardarCompra();
  }

    // Validación de cada detalle de compra
    // let detallesValidos = true;
    // this.validacionesDetalles = this.nuevos_detalles.map((detalle, index) => {
    //   const validacionDetalle = {
    //     fo_compras: detalle.fo_compras > 0,
    //     fo_producto: detalle.fo_producto > 0,
    //     cantidad: detalle.cantidad > 0,
    //     precio: detalle.precio > 0
    //   };

    //   // Actualizamos la variable para la validación global
    //   if (!validacionDetalle.fo_compras || !validacionDetalle.fo_producto || !validacionDetalle.cantidad || !validacionDetalle.precio) {
    //     detallesValidos = false;
    //   }

    //   return validacionDetalle;
    // });



    // if (this.validar_fecha && this.validar_iva && this.validar_fo_proveedor && this.validar_fo_usuario && detallesValidos) {
    //   this.guardarCompra();

    // }
  }

  guardarCompra() {
    // Paso 1: Guardar la compra en la base de datos
    this.scompra.insertarCompra(this.obj_compras).subscribe((compraResponse: any) => {
      if (compraResponse.resultado === 'OK' && compraResponse.id_compra) {
        const idCompra = compraResponse.id_compra; // Obtener el ID de la compra creada

        // Paso 2: Agregar `idCompra` a cada detalle y guardarlos
        this.nuevos_detalles.forEach(detalle => {
          detalle.fo_compras = idCompra; // Asocia el ID de compra
          this.sdetalle.insertarDetalleCompra(detalle).subscribe((detalleResponse: any) => {
            console.log('Detalle guardado:', detalleResponse);
          });
        });

        alert('Compra y detalles guardados exitosamente.');
        this.consulta(); // Refresca los datos
        this.limpiar();  // Limpia el formulario
        this.mostrarForm("ocultar"); // Cierra el formulario
      } else {
        alert('Error al guardar la compra.');
      }
    });
  }


  agregarDetalle() {
    this.nuevos_detalles.push({
      fo_compras: 0,
      fo_producto: 0,
      cantidad: 0,
      precio: 0
    });
    this.validacionesDetalles.push({ fo_compras: true, fo_producto: true, cantidad: true, precio: true });
    console.log('Detalle agregado:', this.nuevos_detalles);
  }

  crearProducto() {
    // Aquí puedes abrir un modal o redirigir a otra vista según necesites
    this.abrirModalProducto();
  }

  mostrarModalProducto = false; // Controla la visibilidad del modal

  abrirModalProducto() {
    this.mostrarModalProducto = true;
  }

  cerrarModalProducto() {
    this.mostrarModalProducto = false;
  }


  guardarNuevoProducto() {
    this.sproducto.insertarProducto(this.nuevoProducto).subscribe((respuesta: any) => {
      if (respuesta.resultado === 'OK') {
        alert('Producto agregado exitosamente.');
        this.consultarProductos(); // Actualiza la lista de productos
        this.cerrarModalProducto(); // Cierra el modal
      } else {
        alert('Error al agregar el producto.');
      }
    });
  }




}
