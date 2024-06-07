import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AsignarPartidoComponent } from './asignar-partido.component';

describe('AsignarPartidoComponent', () => {
  let component: AsignarPartidoComponent;
  let fixture: ComponentFixture<AsignarPartidoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AsignarPartidoComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(AsignarPartidoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
