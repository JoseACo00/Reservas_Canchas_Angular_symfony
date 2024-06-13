import { NgModule } from '@angular/core';
import { JwtModule } from "@auth0/angular-jwt";
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { RegistroUsuarioComponent } from './CrearCuentas/registro-usuario/registro-usuario.component';
import { RegistroAdminComponent } from './CrearCuentas/registro-admin/registro-admin.component';
import { RegistroArbitroComponent } from './CrearCuentas/registro-arbitro/registro-arbitro.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { InicioComponent } from './inicio/inicio.component';
import { NavbarComponent } from './navbar/navbar.component';
import { CanchasComponent } from './Menu/canchas/canchas.component';
import { SobreNosotrosComponent } from './Menu/sobre-nosotros/sobre-nosotros.component';
import { ReservasComponent } from './Menu/reservas/reservas.component';
import { InicioMenuComponent } from './Menu/inicio-menu/inicio-menu.component';
import { ServiciosComponent } from './Menu/servicios/servicios.component';
import { PartidoComponent } from './Menu/partido/partido.component';
import { ContactoComponent } from './Menu/contacto/contacto.component';
import { FooterComponent } from './footer/footer.component';
import { EditCanchaComponent } from './Admin/edit-cancha/edit-cancha.component';
import { ReservasAdminComponent } from './Admin/reservas-admin/reservas-admin.component';
import { PostCanchaComponent } from './Admin/post-cancha/post-cancha.component';
import { ReservaCanchaComponent } from './Usuario/reserva-cancha/reserva-cancha.component';
import { EditReservaComponent } from './Usuario/edit-reserva/edit-reserva.component';
import { PartidosArbitroComponent } from './Arbitro/partidos-arbitro/partidos-arbitro.component';
import { EditarDisponibilidadComponent } from './Arbitro/editar-disponibilidad/editar-disponibilidad.component';
import { PartidosAdminComponent } from './Admin/partidos-admin/partidos-admin.component';
import { AsignarPartidoComponent } from './Admin/asignar-partido/asignar-partido.component';
import { EditarPartidoComponent } from './Admin/editar-partido/editar-partido.component';
import { ListaReservaUsuarioComponent } from './Usuario/lista-reserva-usuario/lista-reserva-usuario.component';
import { PartidosUsuarioComponent } from './Usuario/partidos-usuario/partidos-usuario.component';
import { SimpleNotificationsModule } from 'angular2-notifications';
import { ResetpasswordComponent } from './resetpassword/resetpassword.component';
import { CambiarPasswordComponent } from './cambiar-password/cambiar-password.component';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    RegistroUsuarioComponent,
    RegistroAdminComponent,
    RegistroArbitroComponent,
    InicioComponent,
    NavbarComponent,
    CanchasComponent,
    SobreNosotrosComponent,
    ReservasComponent,
    InicioMenuComponent,
    ContactoComponent,
    ServiciosComponent,
    PartidoComponent,
    FooterComponent,
    PostCanchaComponent,
    ReservaCanchaComponent,
    EditReservaComponent,
    PartidosArbitroComponent,
    EditarDisponibilidadComponent,
    PartidosAdminComponent,
    EditCanchaComponent,
    AsignarPartidoComponent,
    EditarPartidoComponent,
    ListaReservaUsuarioComponent,
    PartidosUsuarioComponent,
    ResetpasswordComponent,
    CambiarPasswordComponent,

  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    ReactiveFormsModule,
    FormsModule,
    HttpClientModule,
    SimpleNotificationsModule.forRoot()

  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
