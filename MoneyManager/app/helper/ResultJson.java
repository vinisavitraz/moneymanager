package helper;

import com.fasterxml.jackson.databind.node.ArrayNode;
import com.fasterxml.jackson.databind.node.BaseJsonNode;
import com.fasterxml.jackson.databind.node.ObjectNode;
import play.libs.Json;

import java.io.PrintWriter;
import java.io.StringWriter;
import java.util.List;

public class ResultJson {
    public static BaseJsonNode makeOk(String message) {
        ObjectNode result = Json.newObject();
        ObjectNode response = Json.newObject();
        result.set("response", response);
        response.put("status", "ok");
        response.put("message", message);
        return result;
    }

    public static BaseJsonNode setToResponse(BaseJsonNode resultNode, String name, BaseJsonNode node) {
        ObjectNode response = (ObjectNode) resultNode.get("response");
        response.set(name, node);
        return resultNode;
    }

    public static BaseJsonNode setToResponse(BaseJsonNode resultNode, String name, Integer value) {
        ObjectNode response = (ObjectNode) resultNode.get("response");
        response.put(name, value);
        return resultNode;
    }

    public static BaseJsonNode setToResponse(BaseJsonNode resultNode, String name, Long value) {
        ObjectNode response = (ObjectNode) resultNode.get("response");
        response.put(name, value);
        return resultNode;
    }

    public static BaseJsonNode setToResponse(BaseJsonNode resultNode, String name, String value) {
        ObjectNode response = (ObjectNode) resultNode.get("response");
        response.put(name, value);
        return resultNode;
    }

    public static BaseJsonNode setToResponse(BaseJsonNode resultNode, String name, Double value) {
        ObjectNode response = (ObjectNode) resultNode.get("response");
        response.put(name, value);
        return resultNode;
    }

    public static BaseJsonNode makeOk(String message, ArrayNode content) {
        ObjectNode result = Json.newObject();
        ObjectNode response = Json.newObject();
        result.set("response", response);
        response.put("status", "ok");
        ArrayNode data = response.putArray("data");
        for (int i=0; i<content.size();i++) {
            data.add(content.get(i));
        }
        ArrayNode array = response.putArray("messages");
        ObjectNode node = Json.newObject();
        node.put("message", message);
        array.add(node);
        return result;
    }

    public static BaseJsonNode makeError(List<String> messages) {
        ObjectNode result = Json.newObject();
        ObjectNode response = Json.newObject();
        result.set("response", response);
        response.put("status", "error");
        ArrayNode array = response.putArray("messages");
        for (String message: messages) {
            ObjectNode node = Json.newObject();
            node.put("message", message);
            array.add(node);
        }
        return result;
    }

    public static BaseJsonNode makeError(Exception exception, String message) {
        ObjectNode result = Json.newObject();
        ObjectNode response = Json.newObject();
        result.set("response", response);
        response.put("status", "error");
        ArrayNode array = response.putArray("messages");
        ObjectNode node = Json.newObject();
        node.put("message", message);
        array.add(node);

        node = Json.newObject();

        StringWriter sw = new StringWriter();
        PrintWriter pw = new PrintWriter(sw);
        exception.printStackTrace(pw);

        node.put("message", "Exception: " + exception.getMessage());
        array.add(node);

        node = Json.newObject();
        node.put("message", "StackTrace: " + sw.toString());
        array.add(node);
        return result;
    }

    public static BaseJsonNode makeError(String message) {
        ObjectNode result = Json.newObject();
        ObjectNode response = Json.newObject();
        result.set("response", response);
        response.put("status", "error");
        response.put("message", message);
        return result;
    }
}
