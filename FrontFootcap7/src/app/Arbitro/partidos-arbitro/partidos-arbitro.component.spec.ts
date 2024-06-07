import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PartidosArbitroComponent } from './partidos-arbitro.component';

describe('PartidosArbitroComponent', () => {
  let component: PartidosArbitroComponent;
  let fixture: ComponentFixture<PartidosArbitroComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PartidosArbitroComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(PartidosArbitroComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
