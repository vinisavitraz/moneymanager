package controllers.api;

import br.framework.interfaces.IConnection;
import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.node.BaseJsonNode;
import com.fasterxml.jackson.databind.node.ObjectNode;
import dao.CategoriaDao;
import helper.ConnectionFactory;
import helper.ResultJson;
import model.entity.Categoria;
import play.mvc.Result;

import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import static play.mvc.Controller.request;

import static play.mvc.Results.*;

public class CategoriaController {
   /* public Result getCategorias(){
        BaseJsonNode result = (ObjectNode) ResultJson.makeOk("Dados ataulizar preço etiqueta atualizados com sucesso");
        return ok(result);
    }*/

   /*
    public Result getCategorias(){
        BaseJsonNode result = (ObjectNode) ResultJson.makeOk("Dados das categorias pesquisados com sucesso");
        IConnection connection = null;
        try {
            connection = ConnectionFactory.newConnection();
            DepartamentoDao dao = new DepartamentoDaoImpl(connection);
            List<Departamento> departamentos = dao.getDepartamentos(lastID);
            result = dao.serializeToJson(departamentos, (ObjectNode) result);
        } catch (SQLException e) {
            logger.error("Exception caught", e);
        } catch (Exception e) {
            logger.error("Exception caught", e);
            result = ResultJson.makeError(e, "Erro ao pesquisar departamentos");
        } finally {
            if (connection != null) {
                connection.close();
            }
        }
        return ok(result);
    }
    */

    public Result insertCategoria() {
        Result returnResult = null;
        BaseJsonNode result = (ObjectNode) ResultJson.makeOk("Dados da categoria inseridos com sucesso");
        IConnection connection = null;
        try {
            List<String> errors = new ArrayList<>();
            JsonNode categoriaJson = request().body().asJson();
            connection = ConnectionFactory.newConnection();
            CategoriaDao dao = new CategoriaDao(connection);
            Categoria categoria = dao.jsonToEntity((ObjectNode) categoriaJson);
            dao.insert(categoria, errors);
            returnResult = ok(result);

            if (errors.size() > 0) {
                result = ResultJson.makeError(errors);
                returnResult = badRequest(result);
            } else {
                ResultJson.setToResponse(result, "id", categoria.getId().getValue());
            }

        } catch (SQLException e) {
            result = ResultJson.makeError(e, "Erro no banco de dados ao inserir categoria");
            returnResult = internalServerError(result);
        } catch (Exception e) {
            result = ResultJson.makeError(e, "Erro ao inserir categoria");
            returnResult = internalServerError(result);
        } finally {
            if (connection != null) {
                connection.close();
            }
        }

        return returnResult;
    }
}
