import { ResetpasswordComponent } from './resetpassword/resetpassword.component';
import { PartidosArbitroComponent } from './Arbitro/partidos-arbitro/partidos-arbitro.component';
import { EditarDisponibilidadComponent } from './Arbitro/editar-disponibilidad/editar-disponibilidad.component';
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
import { AdminGuard } from './guards/Admin/admin.guard';
import { UsuarioGuard } from './guards/User/usuario.guard';
import { ArbitroGuard } from './guards/Arbitro/arbitro.guard';
import { CambiarPasswordComponent } from './cambiar-password/cambiar-password.component';

const routes: Routes = [
  //SIN REGISTRAR
  {path:'Login', component: LoginComponent},
  {path: 'registro-Usuario', component: RegistroUsuarioComponent},
  {path: 'registro-Admin', component: RegistroAdminComponent},
  {path: 'registro-Arbitro', component: RegistroArbitroComponent},
  {path: 'Inicio', component: InicioComponent},
  {path: 'Canchas', component: CanchasComponent },
  {path: 'Sobre-Nosotros', component: SobreNosotrosComponent},
  {path: 'Reservas', component: ReservasComponent},
  {path: 'Contacto', component: ContactoComponent},
  {path: 'Servicios', component: ServiciosComponent},

 //RUTAS PARA ADMIN
 { path: 'CreateCancha', component: PostCanchaComponent, canActivate: [ AdminGuard] }, //CREAR CANCHA ADMIN
 { path: 'Editar/Cancha/:id', component: EditCanchaComponent, canActivate: [AdminGuard] },
 { path: 'PartidosAdmin', component: PartidosAdminComponent, canActivate: [AdminGuard] },

  //ACIONES DE USUARIO
  { path: 'Reservar/Cancha/:id', component: ReservaCanchaComponent , canActivate: [ UsuarioGuard]}, //USUAIRO RESERVA FORMULARIO
  { path: 'Usuario/reserva/:reserva_id/cancha/:cancha_id/editar', component: EditReservaComponent, canActivate: [ UsuarioGuard] }, // EDITAR RESERVA DE USUARIO
  {path: 'Partidos', component: PartidoComponent},
  { path: 'Usuario/reservas', component: ListaReservaUsuarioComponent, canActivate: [ UsuarioGuard] },
  { path: 'Usuario/partidos', component: PartidosUsuarioComponent, canActivate: [ UsuarioGuard] },

  //ACCIONES DE ARBITRO
  { path: 'Arbitro/editar', component: EditarDisponibilidadComponent, canActivate: [ArbitroGuard] },
  { path: 'arbitro/partidos', component: PartidosArbitroComponent, canActivate: [ArbitroGuard] },

  //RESET PASSWORD
  {path: "reset-password", component : ResetpasswordComponent},
  {path: "cambiar-password", component : CambiarPasswordComponent},
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
