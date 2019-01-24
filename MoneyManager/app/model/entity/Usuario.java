package model.entity;

import br.framework.annotations.TableAnnotation;
import br.framework.classes.DataBase.EntityClass;
import model.field.Codigo;
import model.field.Decimal;
import model.field.Literal;
import model.field.Status;

import java.io.Serializable;

@TableAnnotation(tableName = "Usuario", prefix = "usu_")
public class Usuario  extends EntityClass implements Serializable {
    private Codigo id;
    private Literal nome;
    private Literal email;
    private Literal usuario;
    private Literal senha;
    private Decimal saldoDinheiro;
    private Literal idOperacoes;
    private Literal idRecorrentes;
    private Status status;
    private Status ativo;

    //add contrutor status ativo


    public Codigo getId() {
        return id;
    }

    public void setId(Codigo id) {
        this.id = id;
    }

    public Literal getNome() {
        return nome;
    }

    public void setNome(Literal nome) {
        this.nome = nome;
    }

    public Literal getEmail() {
        return email;
    }

    public void setEmail(Literal email) {
        this.email = email;
    }

    public Literal getUsuario() {
        return usuario;
    }

    public void setUsuario(Literal usuario) {
        this.usuario = usuario;
    }

    public Literal getSenha() {
        return senha;
    }

    public void setSenha(Literal senha) {
        this.senha = senha;
    }

    public Decimal getSaldoDinheiro() {
        return saldoDinheiro;
    }

    public void setSaldoDinheiro(Decimal saldoDinheiro) {
        this.saldoDinheiro = saldoDinheiro;
    }

    public Literal getIdOperacoes() {
        return idOperacoes;
    }

    public void setIdOperacoes(Literal idOperacoes) {
        this.idOperacoes = idOperacoes;
    }

    public Literal getIdRecorrentes() {
        return idRecorrentes;
    }

    public void setIdRecorrentes(Literal idRecorrentes) {
        this.idRecorrentes = idRecorrentes;
    }

    public Status getStatus() {
        return status;
    }

    public void setStatus(Status status) {
        this.status = status;
    }

    public Status getAtivo() {
        return ativo;
    }

    public void setAtivo(Status ativo) {
        this.ativo = ativo;
    }
}