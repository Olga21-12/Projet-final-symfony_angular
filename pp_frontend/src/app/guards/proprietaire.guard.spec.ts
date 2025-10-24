import { TestBed } from '@angular/core/testing';
import { CanActivateFn } from '@angular/router';

import { proprietaireGuard } from './proprietaire.guard';

describe('proprietaireGuard', () => {
  const executeGuard: CanActivateFn = (...guardParameters) => 
      TestBed.runInInjectionContext(() => proprietaireGuard(...guardParameters));

  beforeEach(() => {
    TestBed.configureTestingModule({});
  });

  it('should be created', () => {
    expect(executeGuard).toBeTruthy();
  });
});
