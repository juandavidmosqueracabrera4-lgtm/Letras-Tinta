using System.ComponentModel.DataAnnotations;

namespace MyLibrary.Web.Data.Entities
{
    public class Author
    {
        [Key]
        public Guid Id { get; set; }

        [MaxLength(32, ErrorMessage = "El campo {0} debe tener máximo {1} carácteres.")]
        [Required(ErrorMessage = "El campo {0} es requerido.")]
        public string FirstName { get; set; }

        [MaxLength(32, ErrorMessage = "El campo {0} debe tener máximo {1} carácteres.")]
        [Required(ErrorMessage = "El campo {0} es requerido.")]
        public string LastName { get; set; }
    }
}
