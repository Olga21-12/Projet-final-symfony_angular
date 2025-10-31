import { TestBed } from '@angular/core/testing';
import { ProprietaireGuard } from './proprietaire.guard';

describe('ProprietaireGuard', () => {
  let guard: ProprietaireGuard;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    guard = TestBed.inject(ProprietaireGuard);
  });

  it('should be created', () => {
    expect(guard).toBeTruthy();
  });
});
