function addToCart(id){
    fetch("add_to_cart.php?id="+id)
    .then(()=>location.reload());
}
