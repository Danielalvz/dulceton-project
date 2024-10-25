import { Component } from '@angular/core';
import { CategoriaService } from 'src/app/servicios/categoria.service';
import { ProductoService } from 'src/app/servicios/producto.service';
import { ProveedorService } from 'src/app/servicios/proveedor.service';

@Component({
  selector: 'app-producto',
  templateUrl: './producto.component.html',
  styleUrls: ['./producto.component.scss']
})
export class ProductoComponent {

  producto: any;
  categoria: any;
  proveedor: any;

  obj_producto = {
    codigo: "",
    nombre: "",
    fo_categoria: 0,
    valor_compra: 0,
    valor_venta: 0,
    stock: 0,
    venta_al_publico: null,
    fo_proveedor: 0
  }

  validar_codigo = true;
  validar_nombre = true;
  validar_fo_categoria = true;
  validar_valor_compra = true;
  validar_valor_venta = true;
  validar_stock = true;
  validar_venta_al_publico = true;
  validar_fo_proveedor = true;
  mform = false;

  constructor(private sproducto: ProductoService, private scategoria: CategoriaService, private sproveedor: ProveedorService) { }

  ngOnInit(): void { //se ejecuta cada vez que cargue el sitio
    this.consulta();
    this.consultarCategoria();
    this.consultarProveedor();
  }

  consulta() {
    this.sproducto.consultarProductos().subscribe((resultado: any) => {
      this.producto = resultado;
    })
  }

  consultarCategoria() {
    this.scategoria.consultarCategorias().subscribe((resultado: any) => {
      this.categoria = resultado.map((_: any) => {
        _.id_categoria = Number(_.id_categoria);
        return _;
      });
    })
  }

  consultarProveedor() {
    this.sproveedor.consultarProveedores().subscribe((resultado: any) => {
      this.proveedor = resultado.map((_: any) => {
        _.id_proveedor = Number(_.id_proveedor);
        return _;
      });
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

  limpiar() {
    this.obj_producto = {
      codigo: "",
      nombre: "",
      fo_categoria: 0,
      valor_compra: 0,
      valor_venta: 0,
      stock: 0,
      venta_al_publico: null,
      fo_proveedor: 0
    }
  }


  validarProducto() {
    console.log("Valor inicial de venta_al_publico:", this.obj_producto.venta_al_publico); // <-- Agrega aquí para ver el valor inicial

    this.validar_codigo = this.obj_producto.codigo.trim() !== "";

    this.validar_nombre = this.obj_producto.nombre.trim() !== "";

    this.validar_fo_categoria = this.obj_producto.fo_categoria !== 0;

    this.validar_valor_compra = this.obj_producto.valor_compra !== 0 || this.obj_producto.valor_compra > 0;

    this.validar_valor_venta = this.obj_producto.valor_venta !== 0 || this.obj_producto.valor_venta > 0;

    this.validar_stock = this.obj_producto.stock !== 0 || this.obj_producto.stock > 0;

    this.validar_venta_al_publico = this.obj_producto.venta_al_publico !== null;
    console.log("Valor despues de valdiacion venta_al_publico:", this.obj_producto.venta_al_publico);

    this.validar_fo_proveedor = this.obj_producto.fo_proveedor !== 0;

    if (this.validar_codigo && this.validar_fo_categoria && this.validar_fo_proveedor && this.validar_nombre && this.validar_stock && this.validar_valor_compra && this.validar_valor_venta && this.validar_venta_al_publico) {
      this.guardarProducto();

    }
  }

  guardarProducto() {
    console.log('Valor enviado de venta_al_publico:', this.obj_producto.venta_al_publico);
    this.sproducto.insertarProducto(this.obj_producto).subscribe((datos: any) => {
      console.log('Respuesta del servidor:', datos);
      if (datos.resultado === 'OK') {
        this.consulta();
      } else {
        console.error('Error en la respuesta del servidor:', datos.mensaje);
        alert('Error: ' + datos.mensaje);
      }

    });
    this.limpiar();
    this.mostrarForm("ocultar");
  }
}
