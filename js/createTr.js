function add(idchamp) {
	try{
		var addform=document.getElementById("add");
		if(addform){
			addform.remove();
		}
		var conteneur = document.getElementById(idchamp);
		conteneur.appendChild(addform);
	}
	catch(e){
		alert("add function : "+e);
	}
}

function addDonneeInter(idChamp, idlig,nom,qte) {
	//alert("id = "+idChamp+", idlig= "+idlig);
   try {
        var conteneur = document.getElementById(idChamp);                
        var ligne=document.createElement('tr');
        var cellule1 = document.createElement('td');
        var cellule2 = document.createElement('td');
        var cellule3 = document.createElement('td');
        var cellule4 = document.createElement('td');
        cellule1.textContent=idlig;                    
        cellule2.textContent=document.getElementById(nom).value;
        //alert("id = "+idChamp+", idlig= "+idlig);
        cellule3.textContent=document.getElementById(qte).value;                    
        
        var action1=document.createElement('i');
        action1.setAttribute('class','material-icons text-color1');
        action1.textContent="edit";                    
        var action2=document.createElement('i');
        action2.setAttribute('class','material-icons text-color3');
        action2.textContent='delete';
        cellule4.appendChild(action1);
        cellule4.appendChild(action2);

        ligne.appendChild(cellule1);
        ligne.appendChild(cellule2);
        ligne.appendChild(cellule3);
        ligne.appendChild(cellule4);

        conteneur.appendChild(ligne);
        add(idChamp);

        //document.getElementById("fonction").setAttribute('onclick', 'addDonnee("ligne2","idlig2","nom2","qte2")');
        
   }
   catch(e) {
       alert("addDonnee function :  "+e);
    }
}

function addDonneeSrc(idChamp, idlig,materiel,qte) {
	//alert("id = "+idChamp+", idlig= "+idlig);
   try {
        var conteneur = document.getElementById(idChamp);                
        var ligne=document.createElement('tr');
        var cellule1 = document.createElement('td');
        var cellule2 = document.createElement('td');
        var cellule3 = document.createElement('td');
        var cellule4 = document.createElement('td');
        cellule1.textContent=idlig;                    
        cellule2.textContent=materiel;
        //alert("id = "+idChamp+", idlig= "+idlig);
        cellule3.textContent=qte;                    
        
        var action1=document.createElement('i');
        action1.setAttribute('class','material-icons text-color1');
        action1.textContent="edit";                    
        var action2=document.createElement('i');
        action2.setAttribute('class','material-icons text-color3');
        action2.textContent='delete';
        cellule4.appendChild(action1);
        cellule4.appendChild(action2);

        ligne.appendChild(cellule1);
        ligne.appendChild(cellule2);
        ligne.appendChild(cellule3);
        ligne.appendChild(cellule4);

        conteneur.appendChild(ligne);
        add(idChamp);

        //document.getElementById("fonction").setAttribute('onclick', 'addDonnee("ligne2","idlig2","nom2","qte2")');
        
   }
   catch(e) {
       alert("addDonnee function :  "+e);
    }

}            