import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { Routes, RouterModule,  } from '@angular/router';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { LoginComponent } from './login/login.component';
import { RegistroUsuarioComponent } from './CrearCuentas/registro-usuario/registro-usuario.component';
import { RegistroAdminComponent } from './registro-admin/registro-admin.component';
import { RegistroArbitroComponent } from './registro-arbitro/registro-arbitro.component';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    RegistroUsuarioComponent,
    RegistroAdminComponent,
    RegistroArbitroComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,


  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
