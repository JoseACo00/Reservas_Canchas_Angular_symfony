import { ListaReservaUsuarioComponent } from './Usuario/lista-reserva-usuario/lista-reserva-usuario.component';
import { EditCanchaComponent } from './Admin/edit-cancha/edit-cancha.component';
import { ReservaCanchaComponent } from './Usuario/reserva-cancha/reserva-cancha.component';
import { PostCanchaComponent } from './Admin/post-cancha/post-cancha.component';
import { ServiciosComponent } from './Menu/servicios/servicios.component';
import { ContactoComponent } from './Menu/contacto/contacto.component';
import { NgModule, Component } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { RegistroUsuarioComponent } from './CrearCuentas/registro-usuario/registro-usuario.component';
import { RegistroAdminComponent } from './CrearCuentas/registro-admin/registro-admin.component';
import { RegistroArbitroComponent } from './CrearCuentas/registro-arbitro/registro-arbitro.component';
import { InicioComponent } from './inicio/inicio.component';
import { CanchasComponent } from './Menu/canchas/canchas.component';
import { SobreNosotrosComponent } from './Menu/sobre-nosotros/sobre-nosotros.component';
import { ReservasComponent } from './Menu/reservas/reservas.component';
import { LogginGuard } from './guards/login-guard.guard';
import { InicioMenuComponent } from './Menu/inicio-menu/inicio-menu.component';
import { EditReservaComponent } from './Usuario/edit-reserva/edit-reserva.component';
import { PartidoComponent } from './Menu/partido/partido.component';
import { PartidosAdminComponent } from './Admin/partidos-admin/partidos-admin.component';
import { PartidosUsuarioComponent } from './Usuario/partidos-usuario/partidos-usuario.component';

const routes: Routes = [
  {path:'Login', component: LoginComponent},
  {path: 'registro-Usuario', component: RegistroUsuarioComponent},
  {path: 'registro-Admin', component: RegistroAdminComponent},
  {path: 'registro-Arbitro', component: RegistroArbitroComponent},
  {path: 'Inicio', component: InicioComponent},
  {path: 'Canchas', component: CanchasComponent },
  {path: 'Sobre-Nosotros', component: SobreNosotrosComponent},
  {path: 'Reservas', component: ReservasComponent},
  {path: 'Inicio-Footcap7', component: InicioMenuComponent},
  {path: 'Contacto', component: ContactoComponent},
  {path: 'Servicios', component: ServiciosComponent},
  {path: 'CreateCancha', component: PostCanchaComponent}, //CREAR CANCHA ADMIN
  { path: 'Usuario/reserva/:reserva_id/cancha/:cancha_id/editar', component: EditReservaComponent }, // EDITAR RESERVA DE USUARIO
  { path: 'Reservar/Cancha/:id', component: ReservaCanchaComponent }, //USUAIRO RESERVA FORMULARIO
  { path: 'Editar/Cancha/:id', component: EditCanchaComponent },
  {path: 'Partidos', component: PartidoComponent},
  {path: 'PartidosAdmin', component: PartidosAdminComponent},
  { path: 'Usuario/reservas', component: ListaReservaUsuarioComponent },
  { path: 'Usuario/partidos', component: PartidosUsuarioComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
