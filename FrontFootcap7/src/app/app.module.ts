import { NgModule } from '@angular/core';
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

  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    ReactiveFormsModule,
    FormsModule,
    HttpClientModule

  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
