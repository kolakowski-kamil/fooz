document.addEventListener("DOMContentLoaded", function () {
  const otherBooksList = document.getElementById("other-books-list");
  const loading = document.getElementById("loading-indicator");

  if (!otherBooksList || !loading) return;

  const currentPostId = parseInt(document.body.dataset.postId || 0);

  fetch(`/wp-admin/admin-ajax.php?action=get_other_books&exclude=${currentPostId}`)
    .then((response) => response.json())
    .then((data) => {
      loading.style.display = "none";

      if (!data.length) {
        otherBooksList.innerHTML = "<li>No books found.</li>";
        return;
      }

      data.forEach((book) => {
        const li = document.createElement("li");
        li.innerHTML = `
          <strong>${book.title}</strong> <small>(${book.date})</small><br>
          <em>${book.genre.join(", ")}</em><br>
          <p>${book.excerpt}</p>
        `;
        otherBooksList.appendChild(li);
      });
    })
    .catch((error) => {
      loading.innerText = "Failed to load books.";
      console.error("Error loading books:", error);
    });
});