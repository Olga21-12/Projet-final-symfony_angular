import { TruncatePipe } from './truncate.pipe';
import { DomSanitizer } from '@angular/platform-browser';

describe('TruncatePipe (test complet à 100 %)', () => {
  let sanitizerSpy: jasmine.SpyObj<DomSanitizer>;

  beforeEach(() => {
    sanitizerSpy = jasmine.createSpyObj<DomSanitizer>('DomSanitizer', ['bypassSecurityTrustHtml']);
  });

  it('devrait être créé correctement', () => {
    const pipe = new TruncatePipe(sanitizerSpy as any);
    expect(pipe).toBeTruthy();
  });

  // --- Cas 1 : valeur vide ---
  it('retourne une chaîne vide pour null ou undefined', () => {
    const pipe = new TruncatePipe(sanitizerSpy as any);
    expect(pipe.transform(null as any, 10)).toBe('');
    expect(pipe.transform(undefined as any, 10)).toBe('');
  });

  // --- Cas 2 : pas de limite donnée ---
  it('retourne la valeur inchangée si aucune limite n’est donnée', () => {
    const pipe = new TruncatePipe(sanitizerSpy as any);
    const res = pipe.transform('Bonjour le monde', 0);
    expect(res).toBe('Bonjour le monde');
  });

  // --- Cas 3 : valeur non textuelle ---
  it('convertit une valeur non textuelle en chaîne avant le traitement', () => {
    const pipe = new TruncatePipe(sanitizerSpy as any);
    const res = pipe.transform(123456 as any, 3) as string;
    expect(typeof res).toBe('string');
    expect(res.length).toBeGreaterThan(0);
  });

  // --- Cas 4 : texte court ---
  it('ne tronque pas le texte s’il est plus court que la limite', () => {
    const pipe = new TruncatePipe(sanitizerSpy as any);
    const txt = 'Bonjour';
    const res = pipe.transform(txt, 20);
    expect(res).toBe(txt);
  });

  // --- Cas 5 : texte long ---
  it('tronque le texte long et ajoute des points de suspension', () => {
    const pipe = new TruncatePipe(sanitizerSpy as any);
    const txt = 'Ceci est un très long texte à couper proprement';
    const res = pipe.transform(txt, 10) as string;
    expect(res.length).toBeLessThan(txt.length);
    expect(res).toMatch(/(…|\.\.\.)/);
  });

  // --- Cas 6 : différentes limites donnent des résultats différents ---
  it('produit un résultat différent selon la limite', () => {
    const pipe = new TruncatePipe(sanitizerSpy as any);
    const txt = 'Texte à couper';
    const r1 = pipe.transform(txt, 5);
    const r2 = pipe.transform(txt, 12);
    expect(r1).not.toBe(r2);
  });
});
