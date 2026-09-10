using System.ComponentModel.DataAnnotations;

namespace MyLibrary.Web.DTOs
{
    public class CreateAuthorDTO
    {
        [MaxLength(32, ErrorMessage = "El campo {0} debe tener máximo {1} carácteres.")]
        [Required(ErrorMessage = "El campo {0} es requerido.")]
        public string FirstName { get; set; }

        [MaxLength(32, ErrorMessage = "El campo {0} debe tener máximo {1} carácteres.")]
        [Required(ErrorMessage = "El campo {0} es requerido.")]
        public string LastName { get; set; }
    }
}
