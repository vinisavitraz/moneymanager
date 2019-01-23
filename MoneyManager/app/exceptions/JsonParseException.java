package exceptions;

import java.util.List;

public class JsonParseException extends Exception {
    private List<String> errors;


    public JsonParseException(String message, List<String> errors) {
        super(message);
        this.setErrors(errors);
    }


    public List<String> getErrors() {
        return errors;
    }

    public void setErrors(List<String> errors) {
        this.errors = errors;
    }
}
