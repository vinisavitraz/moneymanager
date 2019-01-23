package model.field;

import br.framework.classes.DataBase.EntityField;
import br.framework.classes.helpers.Types.FieldType;

import java.io.Serializable;


public class Codigo extends EntityField implements Serializable {

	/**
   *
   */
  private static final long serialVersionUID = 5237978494722523252L;
  private Integer value;

	public Codigo() {
		super();
		this.value = 0;
		this.setDataType(FieldType.Integer);
		this.setPrecision(10);
		this.setScale(0);		
	}

	public Codigo(Integer value) {
		super();
		this.value = value;
		this.setDataType(FieldType.Integer);
		this.setPrecision(10);
		this.setScale(0);
	}

	@Override
	public Integer getValue() {
		return this.value;
	}

	@Override
	public void setValue(Object value) {
		this.setHasModification(Boolean.TRUE);
		if (value==null) {
			value = 0;
		}
		this.value = (Integer) value;
	}
	
	public void setValue(Long value) {
		Object ObjValue = value;
		this.setValue(ObjValue);
	}

}
