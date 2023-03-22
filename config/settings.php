<?php


return [

	'logo'=>'/logos/logo1.png',
	/* Days after can play the same team */
	'ref_days'=>15,

	/*Time before and after a match that a referee can play another match*/
	
	'ref_time'=>2,

	/*Αν θα ειδοποιείται ο διαιτητής με SMS για τον ορισμό του*/
	'ref_notify'=> true,

	/*Ορισμός Υγειονομικού Προσωπικού*/
	'Doctor-Orismos'=>true,

	/*Υπολογισμός Χλμτρικής Αποζημίωσης Γιατρών*/
	'distanceDoctor'=>false,

	/*Ορισμός Παρατηρητών*/
	'Observer-Orismos'=>true,

	/*Ορισμός Παρατηρητών Διαιτησίας*/
	'refObserver-Orismos'=>true,

	/*Βαθμολογίες Διαιτητών*/
	'refGrades'=>true,

	/* Εκπαιδευτικό Υλικό Για διαιτητές */
	'refEducStaf' => true,

	/*Διαχείριση Ισοβαθμιών*/
	'tieBrake'=>'UEFA',

	/*Live Αναμετρήσεις*/
	'live'=>true,

	/////////////////Ρυθμίσεις Εξοδολογίου/////////////////////////

	/*Χρησιμοπούν Αποστάσεις Από Πόλεις*/
	'cities'=>true,

	/*Χρησιμοπούν Υπολογισμό Αποστάσεων με Google*/
	'google'=>false,

	/*Αχαΐα:1-Λάρισα:2-Ηλεία:3*/
	'eps'=>3,

	/*ΔΙΟδια*/
	'toll'=>true,

	/*Κάθε βοηθός παίρνει διαφορετική χιλιομετρική αποζημίωση*/
	'difDistanceHelper'=>true,

	/*Πληρώνονται οι βοηθοί Ημεραργία*/
	'imergargiaHelpers'=>true,

	/*Πληρώνεται ο Διαιτητής Ημεραργία*/
	'imergargiaReferee'=>true,

	/*Υπολογισμός Χλμτρικής Αποζημίωσης Βοηθών*/
	'distanceHelper'=>false,

	/*Εξοδολόγιο Αποζημίωση Γιατρών*/
	'exodologioDoctor'=>false,

	/*Υπολογισμός Χλμτρικής Αποζημίωσης Γιατρών*/
	'distanceDoctor'=>false,

	/*Εξοδολόγιο Αποζημίωση Παρατηρητών*/
	'exodologioObserver'=>false,

	/*Υπολογισμός Χλμτρικής Αποζημίωσης Παρατηρητών*/
	'distanceObserver'=>false,

	/*Εξοδολόγιο Παρατηρητών Διαιτησίας*/
	'exodologioRefObserver'=>true,

	/*Υπολογισμός Χλμτρικής Αποζημίωσης Παρατηρητών Διατησίας*/
	'distanceRefObserver'=>false,

	/*Εμφάνιση Ποινών Ποδοσφιαριστών*/
	'exodologioShowPlayersPenalties'=>true,

	/*Εμφάνιση Ποινών Αξιωματούχων*/
	'exodologioShowOfficialsPenalties'=>true,

	/*Εξοδολόγια στις Υποδομές*/
	'exodologiaKids'=>true,

	/*Εκτύπωση συμπληρωματικής σελίδας ειδοποίησης*/
	'extraPage'=>true,

	/////////////////Τέλος Ρυθμίσεις Εξοδολογίου/////////////////////////
	/*Αν μπορούν να εγγραφούν Παρατηρητές*/
	'observer'=>true,

	/*Αν μπορούν να εγγραφούν Διαιτητές*/
	'referee'=>true,

	/*Αν μπορούν να εγγραφούν Υπόλογοι Ομάδων*/
	'teamManager'=>true,
	
	/* Ρυθμίσεις Χρηστών Διαιτητών*/
	/*Εμφάνιση Βαθμών*/
	'grades'=>true,

	/*Εκτύπωση Φύλλων Αγώνα*/
	'matchsheets'=>true,

	/*Εισαγωγή Δεδομένων Φύλλου Αγώνα*/
	'insertMatchsheets'=>false,

	/*Εισαγωγή Σκορ από διαιτητές*/
	'insertScore'=>true,

	/*Εισαγωγή link αναμέτρησης*/
	'insertLink'=>true,

	/////////////Ρυθμίσεις Εισαγωγής Στατιστικών/////////////////////////
	'yellow'=>true,

	/////////////////Τέλος Ρυθμίσεις Εισαγωγής Στατιστικών///////////////

	/////////////Ρυθμίσεις Εισαγωγής Storage/////////////////////////
	'storage_folder'=>'epsa',

	/////////////////Τέλος Ρυθμίσεις Εισαγωγής Στατιστικών///////////////

	/////////////Ρυθμίσεις Εφαρμογής Παρατηρητών/////////////////////////
	'live_from_observer'=>true,

	'autoMinute'=>false,

	'livePlayerFill'=>true,

	'liveOwngoal'=>true,

	'liveRed'=>true,

	'liveYellow'=>true,

	/////////////////Τέλος Ρυθμίσεις Εφαρμογής Παρατηρητών///////////////


];