import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ProductoService {

  url = 'http://localhost:8080/dulceton-sena/backend/controlador/ProductoControlador.php';

  constructor(private http: HttpClient) { }

  consultarProductos() {
    return this.http.get(`${this.url}?control=listar`);
  }

  eliminarProducto(id:number) {
    return this.http.get(`${this.url}?control=eliminar&id=${id}`)
  }

  insertarProducto(params:any) {
    return this.http.post(`${this.url}?control=insertar`, JSON.stringify(params))
  }

  editarProducto(id:number, params:any) {
    return this.http.put(`${this.url}?control=editar&id=${id}`, JSON.stringify(params))
  }

  buscarProducto(dato:any) {
    return this.http.get(`${this.url}?control=buscar&dato=${dato}`);
  }
}
