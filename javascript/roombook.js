var detailpanel = document.getElementById("guestdetailpanel");

adduseropen = () => {
    detailpanel.style.display = "flex";
}
adduserclose = () => {
    detailpanel.style.display = "none";
}

// function updatePhone() {
//     var phone = $('select[name="User"] option:selected').data('phone');
//     $('#phone-input').val(phone);
//   }
  
//search bar logic using js
const searchFun = () =>{
        const input = document.getElementById('search_bar');
        const filter = input.value.toUpperCase();
        const table = document.getElementById('table-data');
        const tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) {
            let rowVisible = false;
            const td = tr[i].getElementsByTagName('td');

            for (let j = 0; j < td.length-1; j++) {
                const cellText = td[j].textContent || td[j].innerText;

                if (cellText.toUpperCase().indexOf(filter) > -1) {
                    rowVisible = true;
                    break;
                }
            }

            if (rowVisible) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        }

}
