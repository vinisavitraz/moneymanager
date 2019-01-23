package model.field;

import br.framework.classes.DataBase.EntityField;
import br.framework.classes.helpers.Types.FieldType;

import java.io.Serializable;


public class Texto extends EntityField implements Serializable{

	/**
   * 
   */
  private static final long serialVersionUID = 2080140130533091979L;
  private String value;
	
	public Texto() {
		super();
		this.value = "";		
		this.setDataType(FieldType.Memo);
		this.setPrecision(80);
		this.setScale(0);
	}

	@Override
	public String getValue() {
		return this.value;
	}

	@Override
	public void setValue(Object value) {
		this.setHasModification(Boolean.TRUE);
		if (value==null) {
			value = "";
		}
		this.value = (String) value;
	}
	
	public void setValue(String value) {
		Object ObjValue = value;
		this.setValue(ObjValue);
	}

}
