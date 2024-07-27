import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { PrincipalComponent } from './estructura/principal.component';
import { DashboardComponent } from './modulos/dashboard/dashboard.component';
import { CategoriaComponent } from './modulos/categoria/categoria.component';
import { ProductoComponent } from './modulos/producto/producto.component';
import { ClienteComponent } from './modulos/cliente/cliente.component';
import { PedidoComponent } from './modulos/pedido/pedido.component';
import { UsuarioComponent } from './modulos/usuario/usuario.component';
import { SoporteComponent } from './modulos/soporte/soporte.component';
import { CompraComponent } from './modulos/compra/compra.component';

const routes: Routes = [
  {
    path: '', component: PrincipalComponent,
    children:
      [
        { path: 'dashboard', component: DashboardComponent },
        { path: 'categoria', component: CategoriaComponent },
        { path: 'producto', component: ProductoComponent },
        { path: 'cliente', component: ClienteComponent },
        { path: 'pedido', component: PedidoComponent },
        { path: 'compra', component: CompraComponent },
        { path: 'usuario', component: UsuarioComponent },
        { path: 'soporte', component: SoporteComponent },
        { path: '', redirectTo: 'dashboard', pathMatch: 'full'}
      ]
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
