/*window.onload = () => {
    form1.onsubmit = () =>{
        
        if(conf.value.length == 0){
            alert('Campo(s) não pode ficar vazio(s)');
            return false;
        }
        return true;
    };
   
};
*/
window.onload = () => {
    bt.onclick= () =>{
       alert('Enviado com sucesso');
       salvarForm();
   }
   
}