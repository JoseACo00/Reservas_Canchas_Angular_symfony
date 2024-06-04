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
  {path: 'CreateCancha', component: PostCanchaComponent}
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
