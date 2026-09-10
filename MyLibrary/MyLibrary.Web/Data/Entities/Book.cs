using System.ComponentModel.DataAnnotations;

namespace MyLibrary.Web.Data.Entities
{
    public class Book
    {
        [Key]
        public Guid Id { get; set; }

        [MaxLength(128, ErrorMessage = "El campo {0} debe tener máximo {1} carácteres.")]
        [Required(ErrorMessage = "El campo {0} es requerido.")]
        public string Title { get; set; }

        [Required(ErrorMessage = "El campo {0} es requerido.")]
        public string Description { get; set; }

        public Guid AuthorId { get; set; }

        public Author Author { get; set; }
    }
}
