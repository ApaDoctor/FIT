	
/* c206.c **********************************************************}
{* T�ma: Dvousm�rn� v�zan� line�rn� seznam
**
**                   N�vrh a referen�n� implementace: Bohuslav K�ena, ��jen 2001
**                            P�epracovan� do jazyka C: Martin Tu�ek, ��jen 2004
**                                            �pravy: Bohuslav K�ena, ��jen 2010
**
** Implementujte abstraktn� datov� typ dvousm�rn� v�zan� line�rn� seznam.
** U�ite�n�m obsahem prvku seznamu je hodnota typu int.
** Seznam bude jako datov� abstrakce reprezentov�n prom�nnou
** typu tDLList (DL znamen� Double-Linked a slou�� pro odli�en�
** jmen konstant, typ� a funkc� od jmen u jednosm�rn� v�zan�ho line�rn�ho
** seznamu). Definici konstant a typ� naleznete v hlavi�kov�m souboru c206.h.
**
** Va��m �kolem je implementovat n�sleduj�c� operace, kter� spolu
** s v��e uvedenou datovou ��st� abstrakce tvo�� abstraktn� datov� typ
** obousm�rn� v�zan� line�rn� seznam:
**
**      DLInitList ...... inicializace seznamu p�ed prvn�m pou�it�m,
**      DLDisposeList ... zru�en� v�ech prvk� seznamu,
**      DLInsertFirst ... vlo�en� prvku na za��tek seznamu,
**      DLInsertLast .... vlo�en� prvku na konec seznamu, 
**      DLFirst ......... nastaven� aktivity na prvn� prvek,
**      DLLast .......... nastaven� aktivity na posledn� prvek, 
**      DLCopyFirst ..... vrac� hodnotu prvn�ho prvku,
**      DLCopyLast ...... vrac� hodnotu posledn�ho prvku, 
**      DLDeleteFirst ... zru�� prvn� prvek seznamu,
**      DLDeleteLast .... zru�� posledn� prvek seznamu, 
**      DLPostDelete .... ru�� prvek za aktivn�m prvkem,
**      DLPreDelete ..... ru�� prvek p�ed aktivn�m prvkem, 
**      DLPostInsert .... vlo�� nov� prvek za aktivn� prvek seznamu,
**      DLPreInsert ..... vlo�� nov� prvek p�ed aktivn� prvek seznamu,
**      DLCopy .......... vrac� hodnotu aktivn�ho prvku,
**      DLActualize ..... p�ep�e obsah aktivn�ho prvku novou hodnotou,
**      DLSucc .......... posune aktivitu na dal�� prvek seznamu,
**      DLPred .......... posune aktivitu na p�edchoz� prvek seznamu, 
**      DLActive ........ zji��uje aktivitu seznamu.
**
** P�i implementaci jednotliv�ch funkc� nevolejte ��dnou z funkc�
** implementovan�ch v r�mci tohoto p��kladu, nen�-li u funkce
** explicitn� uvedeno n�co jin�ho.
**
** Nemus�te o�et�ovat situaci, kdy m�sto leg�ln�ho ukazatele na seznam 
** p�ed� n�kdo jako parametr hodnotu NULL.
**
** Svou implementaci vhodn� komentujte!
**
** Terminologick� pozn�mka: Jazyk C nepou��v� pojem procedura.
** Proto zde pou��v�me pojem funkce i pro operace, kter� by byly
** v algoritmick�m jazyce Pascalovsk�ho typu implemenov�ny jako
** procedury (v jazyce C procedur�m odpov�daj� funkce vracej�c� typ void).
**/

#include "c206.h"

int solved;
int errflg;

void DLError() {
/*
** Vytiskne upozorn�n� na to, �e do�lo k chyb�.
** Tato funkce bude vol�na z n�kter�ch d�le implementovan�ch operac�.
**/	
    printf ("*ERROR* Chyba p�i pr�ci se seznamem.\n");
    errflg = TRUE;             /* glob�ln� prom�nn� -- p��znak o�et�en� chyby */
    return;
}

void DLInitList (tDLList *L)	{
/*
** Provede inicializaci seznamu L p�ed jeho prvn�m pou�it�m (tzn. ��dn�
** z n�sleduj�c�ch funkc� nebude vol�na nad neinicializovan�m seznamem).
** Tato inicializace se nikdy nebude prov�d�t nad ji� inicializovan�m
** seznamem, a proto tuto mo�nost neo�et�ujte. V�dy p�edpokl�dejte,
** �e neinicializovan� prom�nn� maj� nedefinovanou hodnotu.
**/
    
  L->First = NULL;
  L->Last = NULL;
  L->Act = NULL;
}

void DLDisposeList (tDLList *L)	{
/*
** Zru�� v�echny prvky seznamu L a uvede seznam do stavu, v jak�m
** se nach�zel po inicializaci. Ru�en� prvky seznamu budou korektn�
** uvoln�ny vol�n�m operace free. 
**/
	
  while (L->First != NULL)
  {
    // pomocna promenna
    tDLElemPtr aux;
    aux = L->First;
    // nasmerujeme zacatek na dalsi prvek seznamu
    L->First = L->First->rptr;
    // uvolnime prvek
    free(aux);
  }
  // "uklidime" ukazatele :-)
  L->Last = NULL;
  L->Act = NULL;
}

void DLInsertFirst (tDLList *L, int val)	{
/*
** Vlo�� nov� prvek na za��tek seznamu L.
** V p��pad�, �e nen� dostatek pam�ti pro nov� prvek p�i operaci malloc,
** vol� funkci DLError().
**/

  // novy prvek
  tDLElemPtr new = NULL;
  // alokujeme pamet pro novy prvek
  if ((new = malloc(sizeof(struct tDLElem))) == NULL)
    DLError();
  else
  {
    // priradime hodnotu
    new->data = val;
    // vsuneme polozku na zacatek
    new->lptr = NULL;
    new->rptr = L->First;
    // pokud vkladame prvni polozku, musi na ni ukazovat i konec seznamu
    if (L->First == NULL)
      L->Last = new;
    else
      L->First->lptr = new;
      // nasmerujeme zacatek na novou polozku
      L->First = new;
  } 
}

void DLInsertLast(tDLList *L, int val)	{
/*
** Vlo�� nov� prvek na konec seznamu L (symetrick� operace k DLInsertFirst).
** V p��pad�, �e nen� dostatek pam�ti pro nov� prvek p�i operaci malloc,
** vol� funkci DLError().
**/ 	

  // novy prvek
  tDLElemPtr new = NULL;
  // alokujeme pamet pro novy prvek
  if ((new = malloc(sizeof(struct tDLElem))) == NULL)
    DLError();
  else
  {
    // priradime hodnotu
    new->data = val;
    // "prilepime" polozku na konec seznamu
    new->lptr = L->Last;
    new->rptr = NULL;
    // pokud vkladame prvni polozku, musi na ni ukazovat i zacatek seznamu
    if (L->First == NULL)
      L->First = new;
    else
      L->Last->rptr = new;
    // nasmerujeme konec na novou polozku
    L->Last = new;
  }
}

void DLFirst (tDLList *L)	{
/*
** Nastav� aktivitu na prvn� prvek seznamu L.
** Funkci implementujte jako jedin� p��kaz (nepo��t�me-li return),
** ani� byste testovali, zda je seznam L pr�zdn�.
**/
	
  L->Act = L->First;
}

void DLLast (tDLList *L)	{
/*
** Nastav� aktivitu na posledn� prvek seznamu L.
** Funkci implementujte jako jedin� p��kaz (nepo��t�me-li return),
** ani� byste testovali, zda je seznam L pr�zdn�.
**/
	
  L->Act = L->Last;
}

void DLCopyFirst (tDLList *L, int *val)	{
/*
** Vr�t� hodnotu prvn�ho prvku seznamu L.
** Pokud je seznam L pr�zdn�, vol� funkci DLError().
**/

  // prazdny seznam
  if (L->First == NULL)
    DLError();
  // vracime hodnotu
  else
    *val = L->First->data;
}

void DLCopyLast (tDLList *L, int *val)	{
/*
** Vr�t� hodnotu posledn�ho prvku seznamu L.
** Pokud je seznam L pr�zdn�, vol� funkci DLError().
**/

  // prazdny seznam
  if (L->First == NULL)
    DLError();
  // vracime hodnotu
  else
    *val =  L->Last->data;
}

void DLDeleteFirst (tDLList *L)	{
/*
** Zru�� prvn� prvek seznamu L. Pokud byl prvn� prvek aktivn�, aktivita 
** se ztr�c�. Pokud byl seznam L pr�zdn�, nic se ned�je.
**/
	
  if (L->First != NULL)
  {
    // pomocna promenna
    tDLElemPtr aux;
    aux = L->First;
    // aktivni prvek - zrusime aktivitu
    if (L->First == L->Act)
      L->Act = NULL;
    // jediny prvek seznamu - "uklidime" ukazatele
    if (L->First == L->Last)
    {
      L->First = NULL;
      L->Last = NULL;
    }
    // vice prvku seznamu
    else
    {
      L->First = L->First->rptr;
      L->First->lptr = NULL;
    }
    // zrusime prvek
    free(aux);
  }
}	

void DLDeleteLast (tDLList *L)	{
/*
** Zru�� posledn� prvek seznamu L. Pokud byl posledn� prvek aktivn�,
** aktivita seznamu se ztr�c�. Pokud byl seznam L pr�zdn�, nic se ned�je.
**/ 
	
	
  if (L->First != NULL)
  {
    // pomocna promenna
    tDLElemPtr aux;
    aux = L->Last;
    // aktivni prvek - zrusime aktivitu
    if (L->Last == L->Act)
      L->Act = NULL;
    // jediny prvek seznamu - "uklidime" ukazatele
    if (L->First == L->Last)
    {
      L->First = NULL;
      L->Last = NULL;
    }
    // vice prvku seznamu
    else
    {
      L->Last = L->Last->lptr;
      L->Last->rptr = NULL;
    }
    // zrusime prvek
    free(aux);
  }
}

void DLPostDelete (tDLList *L)	{
/*
** Zru�� prvek seznamu L za aktivn�m prvkem.
** Pokud je seznam L neaktivn� nebo pokud je aktivn� prvek
** posledn�m prvkem seznamu, nic se ned�je.
**/

  // pomocna promenna
  tDLElemPtr aux;
  // seznam je aktivni, posledni prvek seznamu neni aktivni
  if (L->Act != NULL && L->First != NULL && L->Act != L->Last)
  {
    aux =  L->Act->rptr;
    // ukazatel na prvek, ktery chceme rusit
    L->Act->rptr =  aux->rptr;
    // za rusenou polozkou uz neni dalsi, aktivni je posledni
    if (aux == L->Last)
      L->Last =  L->Act;
    // rusena polozka neni posledni, polozku za provazeme s aktivni
    else
      aux->rptr->lptr =  L->Act;
    // zrusime prvek
    free(aux);   
  }   
}

void DLPreDelete (tDLList *L)	{
/*
** Zru�� prvek p�ed aktivn�m prvkem seznamu L .
** Pokud je seznam L neaktivn� nebo pokud je aktivn� prvek
** prvn�m prvkem seznamu, nic se ned�je.
**/

  // pomocna promenna
  tDLElemPtr aux;
  // seznam je aktivni, prvni prvek seznamu neni aktivni
  if (L->Act != NULL && L->First != NULL && L->Act != L->First)
  {
    aux =  L->Act->lptr;
    // ukazatel na prvek, ktery chceme rusit
    L->Act->lptr =  aux->lptr;
    // pred rusenou polozkou uz nic neni, aktivni je prvni
    if (aux == L->First)
      L->First =  L->Act;
    // rusena polozka neni prvni, polozku pred provazeme s aktivni
    else
      aux->lptr->rptr =  L->Act;
    // zrusime prvek
    free(aux); 
  }
}

void DLPostInsert (tDLList *L, int val) {
/*
** Vlo�� prvek za aktivn� prvek seznamu L.
** Pokud nebyl seznam L aktivn�, nic se ned�je.
** V p��pad�, �e nen� dostatek pam�ti pro nov� prvek p�i operaci malloc,
** vol� funkci DLError().
**/
	
  if (L->Act != NULL)
  {
    // novy prvek
    tDLElemPtr new = NULL;
    // alokujeme pamet pro novy prvek
    if ((new = malloc(sizeof(struct tDLElem))) == NULL)
      DLError();
    else
    {
      // priradime hodnotu
      new->data =  val;
      // ukazatele na predchozi a dalsi
      new->lptr = L->Act;
      new->rptr =  L->Act->rptr;
      //navazeme polozku do seznamu
      L->Act->rptr = new;
      // navazeme zprava novou polozku
      if (L->Act != L->Last)
	new->rptr->lptr = new;
      // nastavime novou posledni polozku
      else
	L->Last = new;
    } 
  }
}


void DLPreInsert (tDLList *L, int val)		{
/*
** Vlo�� prvek p�ed aktivn� prvek seznamu L.
** Pokud nebyl seznam L aktivn�, nic se ned�je.
** V p��pad�, �e nen� dostatek pam�ti pro nov� prvek p�i operaci malloc,
** vol� funkci DLError().
**/
	
  if (L->Act != NULL)
  {
    // novy prvek
    tDLElemPtr new = NULL;
    // alokujeme pamet pro novy prvek
    if ((new = malloc(sizeof(struct tDLElem))) == NULL)
      DLError();
    else
    {
      // priradime hodnotu
      new->data =  val;
      // ukazatele na predchozi a dalsi
      new->rptr = L->Act;
      new->lptr =  L->Act->lptr;
      // navazeme polozku do seznamu
      L->Act->lptr = new;
      // navazeme zleva novou polozku
      if (L->Act != L->First)
	new->lptr->rptr = new;
      // nastavime novou prvni polozku
      else
	L->First = new;
    } 
  }
}

void DLCopy (tDLList *L, int *val)	{
/*
** Vr�t� hodnotu aktivn�ho prvku seznamu L.
** Pokud seznam L nen� aktivn�, vol� funkci DLError ().
**/

  // seznam neni aktivni, volame chybu
  if (L->Act == NULL)
    DLError();
  // seznam je aktivni, vratime hodnotu
  else
    *val = L->Act->data;
}

void DLActualize (tDLList *L, int val) {
/*
** P�ep�e obsah aktivn�ho prvku seznamu L.
** Pokud seznam L nen� aktivn�, ned�l� nic.
**/

  // seznam je aktivni, prepiseme data
  if (L->Act != NULL)
  {
    L->Act->data = val;
  }
}

void DLSucc (tDLList *L)	{
/*
** Posune aktivitu na n�sleduj�c� prvek seznamu L.
** Nen�-li seznam aktivn�, ned�l� nic.
** V�imn�te si, �e p�i aktivit� na posledn�m prvku se seznam stane neaktivn�m.
**/

  // seznam je aktivni
  if (L->Act != NULL)
  {
    // aktivni prvek neni posledni, posouvame
    if (L->Act != L->Last)
      L->Act = L->Act->rptr;
    // ztracime aktivitu
    else
      L->Act = NULL;
  }
}


void DLPred (tDLList *L)	{
/*
** Posune aktivitu na p�edchoz� prvek seznamu L.
** Nen�-li seznam aktivn�, ned�l� nic.
** V�imn�te si, �e p�i aktivit� na prvn�m prvku se seznam stane neaktivn�m.
**/

  // seznam je aktivni
  if (L->Act != NULL)
  {
    // aktivni prvek neni prvni, posouvame
    if (L->Act != L->First)
      L->Act = L->Act->lptr;
    // ztracime aktivitu
    else
      L->Act = NULL;
  }
}

int DLActive (tDLList *L) {		
/*
** Je-li seznam aktivn�, vrac� true. V opa�n�m p��pad� vrac� false.
** Funkci implementujte jako jedin� p��kaz.
**/
	
  return (L->Act != NULL ? TRUE : FALSE);
}

/* Konec c206.c*/
