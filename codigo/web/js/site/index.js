document.addEventListener("DOMContentLoaded", function() {
    if (!sessionStorage.getItem("modalShown") && !filterApplied) {
        setTimeout(() => {
            const modal = new bootstrap.Modal(document.getElementById('modalUbicacion'));
            modal.show();
            sessionStorage.setItem("modalShown", "true");
        }, 1000);
    }

    const inputCiudad = document.getElementById("inputCiudad");
    const resultados = document.getElementById("listaResultados");

    inputCiudad.addEventListener("input", function() {
        let query = inputCiudad.value.trim();
        if (query.length < 2) {
            resultados.innerHTML = "";
            return;
        }
        fetch(`${buscarUbicacionUrl}&q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                resultados.innerHTML = "";
                if (data.length > 0) {
                    data.forEach(item => {
                        let div = document.createElement("a");
                        div.classList.add("list-group-item", "list-group-item-action");
                        div.innerHTML = `
                            <div>${item.nombre}</div>
                            <small style="color:#6c757d;">${item.padre}</small>
                        `;
                        div.href = "#";
                        div.addEventListener("click", (e) => {
                            e.preventDefault();
                            inputCiudad.value = item.nombre;
                            resultados.innerHTML = "";
                        });
                        resultados.appendChild(div);
                    });
                } else {
                    resultados.innerHTML = '<p class="list-group-item">No encontrado.</p>';
                }
            });
    });

    document.getElementById("aceptarFiltro").onclick = () => {
        const ciudad = inputCiudad.value.trim();
        if (ciudad) {
            window.location.href = `${indexUrl}&ciudad=${encodeURIComponent(ciudad)}`;
        } else {
            alert("Por favor, selecciona una ubicación.");
        }
    };

    document.getElementById("cancelarFiltro").onclick = () => {
        const modalEl = document.getElementById('modalUbicacion');
        const modalInstance = bootstrap.Modal.getInstance(modalEl);
        if (modalInstance) {
            modalInstance.hide();
        }
    };
});